<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * Menampilkan daftar pengembalian (transaksi yang masih dipinjam)
     */
    public function index()
    {
        // Peminjaman aktif (status dipinjam)
        $pengembalian = Transaksi::where('status', 'dipinjam')
                                 ->with(['anggota', 'buku'])
                                 ->latest()
                                 ->paginate(15);

        // Riwayat peminjaman (semua transaksi)
        $riwayat = Transaksi::with(['anggota', 'buku'])
                            ->latest()
                            ->paginate(15, ['*'], 'riwayat_page');

        return view('Pengembalian.index', compact('pengembalian', 'riwayat'));
    }

    /**
     * Menampilkan form pengembalian
     */
    public function create(string $id)
    {
        $transaksi = Transaksi::with(['anggota', 'buku'])->findOrFail($id);

        // Hanya bisa proses pengembalian jika status masih dipinjam
        if ($transaksi->status !== 'dipinjam') {
            return redirect()->route('pengembalian.index')
                           ->with('error', 'Transaksi ini sudah dikembalikan sebelumnya.');
        }

        // Estimasi keterlambatan & denda berdasarkan aturan sirkulasi (Pengaturan).
        $lamaPinjam   = (int) Setting::get('lama_pinjam_hari', 7);
        $dendaPerHari = (float) Setting::get('denda_per_hari', 1000);
        $jatuhTempo   = \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->startOfDay()->addDays($lamaPinjam);

        $hariTerlambat = $jatuhTempo->lessThan(now()->startOfDay())
            ? (int) $jatuhTempo->diffInDays(now()->startOfDay())
            : 0;

        $estimasiDenda = $hariTerlambat * $dendaPerHari;

        return view('Pengembalian.create', compact(
            'transaksi',
            'lamaPinjam',
            'dendaPerHari',
            'jatuhTempo',
            'hariTerlambat',
            'estimasiDenda'
        ));
    }

    /**
     * Menyimpan data pengembalian
     */
    public function store(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'dipinjam') {
            return redirect()->route('pengembalian.index')
                ->with('error', 'Transaksi ini sudah dikembalikan sebelumnya.');
        }

        // Validasi
        $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:' . $transaksi->tanggal_pinjam,
            'denda' => 'nullable|numeric|min:0',
        ]);

        // Denda otomatis dari aturan sirkulasi jika petugas tidak mengisi manual.
        $denda = $request->filled('denda')
            ? $request->input('denda')
            : $this->hitungDenda($transaksi, $request->tanggal_kembali);

        DB::transaction(function () use ($transaksi, $request, $denda) {
            $lockedTransaksi = Transaksi::whereKey($transaksi->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedTransaksi->status !== 'dipinjam') {
                abort(409, 'Transaksi ini sudah dikembalikan sebelumnya.');
            }

            $lockedTransaksi->update([
                'tanggal_kembali' => $request->tanggal_kembali,
                'denda' => $denda,
                'status' => 'dikembalikan',
            ]);

            // Stok buku bertambah kembali setelah dikembalikan.
            DB::table('buku')->where('id_buku', $lockedTransaksi->id_buku)->update([
                'jumlah_stok' => DB::raw('COALESCE(jumlah_stok, 0) + 1'),
                'updated_at'  => now(),
            ]);

        });

        return redirect()->route('pengembalian.index')
                       ->with('success', 'Pengembalian buku berhasil dicatat.');
    }

    /**
     * Menampilkan detail pengembalian
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with(['anggota', 'buku'])->findOrFail($id);

        return view('Pengembalian.show', compact('transaksi'));
    }

    /**
     * Menampilkan riwayat semua pengembalian
     */
    public function history()
    {
        $pengembalian = Transaksi::where('status', 'dikembalikan')
                                 ->with(['anggota', 'buku'])
                                 ->latest()
                                 ->paginate(15);

        return view('Pengembalian.history', compact('pengembalian'));
    }

    /**
     * Hitung denda keterlambatan otomatis berdasarkan pengaturan.
     */
    private function hitungDenda(Transaksi $transaksi, string $tanggalKembali): float
    {
        $lamaPinjam   = (int) Setting::get('lama_pinjam_hari', 7);
        $dendaPerHari = (float) Setting::get('denda_per_hari', 1000);

        $jatuhTempo = \Carbon\Carbon::parse($transaksi->tanggal_pinjam)
            ->startOfDay()
            ->addDays($lamaPinjam);

        $kembali = \Carbon\Carbon::parse($tanggalKembali)->startOfDay();

        $hariTerlambat = $kembali->greaterThan($jatuhTempo)
            ? (int) $jatuhTempo->diffInDays($kembali)
            : 0;

        return $hariTerlambat * $dendaPerHari;
    }
}
