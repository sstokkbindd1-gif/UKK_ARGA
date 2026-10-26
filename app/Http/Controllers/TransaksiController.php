<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['anggota', 'buku'])->latest()->paginate(15);
        return view('Transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $anggota = Anggota::all();
        $buku = Buku::orderBy('judul_buku')->get();

        // Default jatuh tempo mengikuti aturan sirkulasi (halaman Pengaturan).
        $lamaPinjam     = (int) Setting::get('lama_pinjam_hari', 7);
        $defaultPinjam  = now()->toDateString();
        $defaultKembali = now()->addDays($lamaPinjam)->toDateString();

        return view('Transaksi.create', compact(
            'anggota',
            'buku',
            'lamaPinjam',
            'defaultPinjam',
            'defaultKembali'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'denda' => 'nullable|numeric|min:0',
        ]);

        // Jika denda tidak di-input, set default 0
        if (!isset($data['denda']) || $data['denda'] === null) {
            $data['denda'] = 0;
        }

        $isPinjamanAktif = in_array($data['status'], ['dipinjam', 'terlambat'], true);

        // Batas jumlah buku yang boleh dipinjam anggota (dari Pengaturan).
        $batasPinjam = (int) Setting::get('maks_pinjam', 3);
        $sedangDipinjam = Transaksi::where('id_anggota', $data['id_anggota'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        if ($isPinjamanAktif && $sedangDipinjam >= $batasPinjam) {
            return back()
                ->withErrors(['id_anggota' => "Anggota ini sudah mencapai batas peminjaman (maksimal {$batasPinjam} buku)."])
                ->withInput();
        }

        if ($isPinjamanAktif && !$this->masihTersedia($data['id_buku'])) {
            return back()->withErrors(['id_buku' => 'Stok buku tidak tersedia.'])->withInput();
        }

        DB::transaction(function () use ($data, $isPinjamanAktif) {
            Transaksi::create($data);

            // Stok berkurang 1 ketika buku keluar dipinjam.
            if ($isPinjamanAktif) {
                DB::table('buku')->where('id_buku', $data['id_buku'])->update([
                    'jumlah_stok' => DB::raw('COALESCE(jumlah_stok, 0) - 1'),
                    'updated_at'  => now(),
                ]);
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['anggota', 'buku']);
        return view('Transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $anggota = Anggota::all();
        $buku = Buku::orderBy('judul_buku')->get();
        return view('Transaksi.create', compact('transaksi', 'anggota', 'buku'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_buku' => 'required|exists:buku,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'denda' => 'nullable|numeric|min:0',
        ]);

        $statusLama = $transaksi->status;
        $baruAktif  = in_array($data['status'], ['dipinjam', 'terlambat'], true);
        $lamaAktif  = in_array($statusLama, ['dipinjam', 'terlambat'], true);

        // Kembalikan ke status dipinjam: stok harus cukup.
        if (!$lamaAktif && $baruAktif && !$this->masihTersedia($data['id_buku'])) {
            return back()->withErrors(['id_buku' => 'Stok buku tidak tersedia.'])->withInput();
        }

        DB::transaction(function () use ($transaksi, $data, $lamaAktif, $baruAktif) {
            $transaksi->update($data);

            // Penyesuaian stok mengikuti perubahan status.
            if ($lamaAktif && !$baruAktif) {
                DB::table('buku')->where('id_buku', $transaksi->id_buku)->update([
                    'jumlah_stok' => DB::raw('COALESCE(jumlah_stok, 0) + 1'),
                    'updated_at'  => now(),
                ]);
            } elseif (!$lamaAktif && $baruAktif) {
                DB::table('buku')->where('id_buku', $transaksi->id_buku)->update([
                    'jumlah_stok' => DB::raw('COALESCE(jumlah_stok, 0) - 1'),
                    'updated_at'  => now(),
                ]);
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        // Menghapus transaksi yang masih aktif mengembalikan stok.
        $aktif = in_array($transaksi->status, ['dipinjam', 'terlambat'], true);

        DB::transaction(function () use ($transaksi, $aktif) {
            if ($aktif) {
                DB::table('buku')->where('id_buku', $transaksi->id_buku)->update([
                    'jumlah_stok' => DB::raw('COALESCE(jumlah_stok, 0) + 1'),
                    'updated_at'  => now(),
                ]);
            }

            $transaksi->delete();
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi dihapus.');
    }

    /**
     * Apakah masih ada salinan buku yang tersedia untuk dipinjam?
     *
     * jumlah_stok sudah otomatis berkurang saat buku dipinjam dan bertambah
     * kembali saat dikembalikan, jadi pengecekan cukup dari nilai stok itu
     * saja (tidak dikurangi lagi dengan jumlah pinjaman aktif).
     */
    private function masihTersedia(int $bookId): bool
    {
        $buku = Buku::find($bookId);

        return $buku !== null && (int) ($buku->jumlah_stok ?? 0) > 0;
    }
}
