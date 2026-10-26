<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Lama peminjaman (hari) sebelum jatuh tempo.
     */
    public const LAMA_PINJAM_HARI = 7;

    /**
     * Denda keterlambatan per hari.
     */
    public const DENDA_PER_HARI = 500;

    /* ==================================================================
       DASHBOARD USER
    ================================================================== */

    public function dashboard()
    {
        $anggota = $this->anggotaLogin();

        $sedangDipinjam = collect();
        $totalPeminjaman = 0;
        $totalDikembalikan = 0;
        $menungguPengembalian = 0;

        if ($anggota) {
            $transaksiSaya = Transaksi::where('id_anggota', $anggota->id_anggota);

            $totalPeminjaman   = (clone $transaksiSaya)->count();
            $totalDikembalikan = (clone $transaksiSaya)->where('status', 'dikembalikan')->count();

            $sedangDipinjam = (clone $transaksiSaya)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->with('buku')
                ->orderBy('tanggal_pinjam')
                ->get();

            $menungguPengembalian = $sedangDipinjam->count();
        }

        // Statistik kartu (semua dari database, tanpa angka hard-code).
        $statistik = [
            'sedang_dipinjam'      => $sedangDipinjam->count(),
            'menunggu_pengembalian' => $menungguPengembalian,
            'total_peminjaman'     => $totalPeminjaman,
            'total_dikembalikan'   => $totalDikembalikan,
        ];

        // Buku terbaru / rekomendasi untuk dashboard.
        $bukuTerbaru = Buku::query()
            ->withCount(['transaksi as pinjam_aktif_count' => function ($q) {
                $q->whereIn('status', ['dipinjam', 'terlambat']);
            }])
            ->latest('created_at')
            ->take(4)
            ->get();

        foreach ($bukuTerbaru as $buku) {
            $buku->tersedia = $this->tersedia($buku);
        }

        return view('user.dashboard', compact(
            'statistik',
            'sedangDipinjam',
            'bukuTerbaru'
        ));
    }

    /* ==================================================================
       KATALOG BUKU + PENCARIAN
    ================================================================== */

    public function katalog(Request $request)
    {
        $kataKunci = trim((string) $request->query('q', ''));

        $query = Buku::query()
            ->withCount(['transaksi as pinjam_aktif_count' => function ($q) {
                $q->whereIn('status', ['dipinjam', 'terlambat']);
            }]);

        if ($kataKunci !== '') {
            $query->where(function ($w) use ($kataKunci) {
                $w->where('judul_buku', 'like', "%{$kataKunci}%")
                  ->orWhere('pengarang', 'like', "%{$kataKunci}%")
                  ->orWhere('kategori', 'like', "%{$kataKunci}%");
            });
        }

        $buku = $query->latest('created_at')->paginate(12)->withQueryString();

        foreach ($buku as $item) {
            $item->tersedia = $this->tersedia($item);
        }

        return view('user.katalog', [
            'buku'      => $buku,
            'kataKunci' => $kataKunci,
        ]);
    }

    /* ==================================================================
       DETAIL BUKU
    ================================================================== */

    public function detailBuku(string $id)
    {
        $buku = Buku::query()
            ->withCount(['transaksi as pinjam_aktif_count' => function ($q) {
                $q->whereIn('status', ['dipinjam', 'terlambat']);
            }])
            ->findOrFail($id);

        $buku->tersedia = $this->tersedia($buku);

        // Apakah buku ini sedang dipinjam oleh user yang login?
        $anggota = $this->anggotaLogin();
        $sedangDipinjamOlehSaya = false;

        if ($anggota) {
            $sedangDipinjamOlehSaya = Transaksi::where('id_anggota', $anggota->id_anggota)
                ->where('id_buku', $buku->id_buku)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->exists();
        }

        return view('user.buku_detail', compact('buku', 'sedangDipinjamOlehSaya'));
    }

    /* ==================================================================
       PEMINJAMAN SAYA
    ================================================================== */

    public function peminjaman()
    {
        $sedangDipinjam = $this->pinjamanAktif()->get();

        return view('user.peminjaman', compact('sedangDipinjam'));
    }

    /* ==================================================================
       PROSES PEMINJAMAN BUKU
    ================================================================== */

    public function peminjamanStore(Request $request)
    {
        $data = $request->validate([
            'id_buku' => ['required', 'exists:buku,id_buku'],
        ]);

        $anggota = $this->anggotaLogin();

        if (!$anggota) {
            return back()->with('error', 'Akun Anda belum memiliki data anggota. Silakan hubungi petugas perpustakaan.');
        }

        $buku = Buku::find($data['id_buku']);

        if (!$buku) {
            return back()->with('error', 'Buku tidak ditemukan.');
        }

        // Cegah user meminjam judul yang sama selama belum dikembalikan.
        $masihDipinjam = Transaksi::where('id_anggota', $anggota->id_anggota)
            ->where('id_buku', $buku->id_buku)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($masihDipinjam) {
            return back()->with('error', 'Anda masih meminjam buku ini dan belum mengembalikannya.');
        }

        try {
            DB::transaction(function () use ($anggota, $buku) {
                $bukuTerkunci = Buku::whereKey($buku->id_buku)->lockForUpdate()->firstOrFail();

                // jumlah_stok sudah berkurang setiap kali buku dipinjam, jadi
                // cukup cek nilai stoknya saja (tidak dikurangi jumlah pinjaman lagi).
                $stok = max(0, (int) ($bukuTerkunci->jumlah_stok ?? 0));

                if ($stok <= 0) {
                    throw new \RuntimeException('Buku sedang tidak tersedia.');
                }

                // Stok buku berkurang 1.
                DB::table('buku')->where('id_buku', $bukuTerkunci->id_buku)->update([
                    'jumlah_stok' => DB::raw('COALESCE(jumlah_stok, 0) - 1'),
                    'updated_at'  => now(),
                ]);

                // Simpan transaksi peminjaman.
                Transaksi::create([
                    'id_anggota'      => $anggota->id_anggota,
                    'id_buku'         => $bukuTerkunci->id_buku,
                    'tanggal_pinjam'  => now()->toDateString(),
                    'tanggal_kembali' => null,
                    'status'          => 'dipinjam',
                    'denda'           => 0,
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('user.peminjaman.index')
            ->with('success', "Berhasil meminjam buku \"{$buku->judul_buku}\".");
    }

    /* ==================================================================
       PENGEMBALIAN BUKU
    ================================================================== */

    public function pengembalian()
    {
        // Daftar buku yang sedang dipinjam dan harus dikembalikan,
        // urut dari yang paling lama dipinjam.
        $harusDikembalikan = $this->pinjamanAktif()
            ->orderBy('tanggal_pinjam')
            ->get();

        return view('user.pengembalian', compact('harusDikembalikan'));
    }

    /**
     * Proses pengembalian buku oleh user.
     * Mengikuti mekanisme pengembalian yang sudah ada
     * (PengembalianController): status menjadi "dikembalikan".
     */
    public function kembalikan(string $id)
    {
        $anggota = $this->anggotaLogin();

        if (!$anggota) {
            return back()->with('error', 'Data anggota tidak ditemukan.');
        }

        // Pastikan transaksi ini milik user yang login.
        $transaksi = Transaksi::whereKey($id)
            ->where('id_anggota', $anggota->id_anggota)
            ->first();

        if (!$transaksi) {
            return back()->with('error', 'Transaksi peminjaman tidak ditemukan.');
        }

        if (!in_array($transaksi->status, ['dipinjam', 'terlambat'], true)) {
            return back()->with('error', 'Transaksi ini sudah dikembalikan sebelumnya.');
        }

        try {
            DB::transaction(function () use ($transaksi) {
                $terkunci = Transaksi::whereKey($transaksi->id_transaksi)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!in_array($terkunci->status, ['dipinjam', 'terlambat'], true)) {
                    abort(409, 'Transaksi ini sudah dikembalikan sebelumnya.');
                }

                $hariIni       = now()->startOfDay();
                $jatuhTempo    = $this->tanggalJatuhTempo($terkunci);
                $terlambatHari = $hariIni->gt($jatuhTempo)
                    ? $hariIni->diffInDays($jatuhTempo)
                    : 0;

                // Denda otomatis jika melewati batas pengembalian.
                $denda = $terlambatHari > 0 ? $terlambatHari * self::DENDA_PER_HARI : 0;

                $terkunci->update([
                    'tanggal_kembali' => $hariIni->toDateString(),
                    'status'          => 'dikembalikan',
                    'denda'           => $denda,
                ]);

                // Stok buku bertambah 1 kembali.
                DB::table('buku')->where('id_buku', $terkunci->id_buku)->update([
                    'jumlah_stok' => DB::raw('COALESCE(jumlah_stok, 0) + 1'),
                    'updated_at'  => now(),
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Pengembalian gagal diproses. Silakan coba lagi.');
        }

        return redirect()
            ->back()
            ->with('success', 'Buku berhasil dikembalikan. Terima kasih!');
    }

    /* ==================================================================
       HISTORY PEMINJAMAN
    ================================================================== */

    public function history()
    {
        $anggota = $this->anggotaLogin();

        $riwayat = Transaksi::query()
            ->with('buku')
            ->when($anggota, function ($q) use ($anggota) {
                $q->where('id_anggota', $anggota->id_anggota);
            }, function ($q) {
                // Tidak punya data anggota: jangan tampilkan transaksi lain.
                $q->whereRaw('1 = 0');
            })
            ->orderByDesc('tanggal_pinjam')
            ->paginate(10)
            ->withQueryString();

        return view('user.history', compact('riwayat'));
    }

    /* ==================================================================
       PROFIL USER
    ================================================================== */

    public function profil()
    {
        $user    = Auth::user();
        $anggota = $this->anggotaLogin();

        return view('user.profil', compact('user', 'anggota'));
    }

    public function profilUpdate(Request $request)
    {
        $user = Auth::user();
        $anggota = $this->anggotaLogin();

        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        if ($anggota) {
            $rules['nis']    = ['required', 'string', 'max:255', 'unique:anggota,nis,' . $anggota->id_anggota . ',id_anggota'];
            $rules['kelas']  = ['nullable', 'string', 'max:255'];
            $rules['alamat'] = ['nullable', 'string', 'max:255'];
        }

        $data = $request->validate($rules);

        DB::transaction(function () use ($data, $user, $anggota) {
            $userData = [
                'name'  => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            $user->update($userData);

            if ($anggota) {
                $anggota->update([
                    'nis'    => $data['nis'] ?? $anggota->nis,
                    'kelas'  => $data['kelas'] ?? null,
                    'alamat' => $data['alamat'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('user.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /* ==================================================================
       HELPER PRIVAT
    ================================================================== */

    /**
     * Data anggota milik user yang sedang login.
     */
    private function anggotaLogin(): ?Anggota
    {
        return Anggota::where('id_user', Auth::id())->first();
    }

    /**
     * Query dasar daftar pinjaman aktif milik user login.
     */
    private function pinjamanAktif()
    {
        $anggota = $this->anggotaLogin();

        return Transaksi::query()
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->when(
                $anggota,
                function ($q) use ($anggota) {
                    $q->where('id_anggota', $anggota->id_anggota);
                },
                function ($q) {
                    // Jika tidak punya data anggota, hasil kosong.
                    $q->whereRaw('1 = 0');
                }
            )
            ->with('buku');
    }

    /**
     * Apakah sebuah buku tersedia untuk dipinjam?
     *
     * jumlah_stok sudah otomatis berkurang saat buku dipinjam dan bertambah
     * kembali saat dikembalikan, jadi pengecekan cukup dari nilai stok itu
     * saja (tidak dikurangi lagi dengan jumlah pinjaman aktif).
     */
    private function tersedia(Buku $buku): bool
    {
        return (int) ($buku->jumlah_stok ?? 0) > 0;
    }

    /**
     * Tanggal jatuh tempo peminjaman (tanggal_pinjam + LAMA_PINJAM_HARI).
     */
    public static function tanggalJatuhTempo(Transaksi $transaksi): \Carbon\Carbon
    {
        return \Carbon\Carbon::parse($transaksi->tanggal_pinjam)
            ->startOfDay()
            ->addDays(self::LAMA_PINJAM_HARI);
    }
}

