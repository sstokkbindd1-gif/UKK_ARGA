<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Status transaksi yang valid untuk filter.
     */
    private const STATUS = ['dipinjam', 'dikembalikan', 'terlambat'];

    /**
     * Terapkan filter (dari, sampai, status) ke query transaksi.
     */
    private function filterTransaksi(Request $request)
    {
        $dari   = $request->query('dari');
        $sampai = $request->query('sampai');
        $status = $request->query('status');

        return Transaksi::with(['anggota', 'buku'])
            ->when($dari, fn ($query) => $query->whereDate('tanggal_pinjam', '>=', $dari))
            ->when($sampai, fn ($query) => $query->whereDate('tanggal_pinjam', '<=', $sampai))
            ->when(in_array($status, self::STATUS, true), fn ($query) => $query->where('status', $status));
    }

    /**
     * Ringkasan angka berdasarkan query yang sudah difilter.
     */
    private function ringkasan($query): array
    {
        return [
            'totalBuku'      => Buku::count(),
            'totalAnggota'   => Anggota::count(),
            'totalTransaksi' => (clone $query)->count(),
            'dipinjam'       => (clone $query)->where('status', 'dipinjam')->count(),
            'dikembalikan'   => (clone $query)->where('status', 'dikembalikan')->count(),
            'terlambat'      => (clone $query)->where('status', 'terlambat')->count(),
            'totalDenda'     => (clone $query)->sum('denda'),
        ];
    }

    /**
     * Ambil filter aktif untuk form dan header cetak.
     */
    private function filterAktif(Request $request): array
    {
        return [
            'dari'   => $request->query('dari'),
            'sampai' => $request->query('sampai'),
            'status' => in_array($request->query('status'), self::STATUS, true) ? $request->query('status') : '',
        ];
    }

    public function index(Request $request)
    {
        $query  = $this->filterTransaksi($request);
        $filter = $this->filterAktif($request);

        $transaksi = (clone $query)
            ->latest('tanggal_pinjam')
            ->paginate(15)
            ->withQueryString();

        return view('report.index', $this->ringkasan($query) + [
            'transaksi' => $transaksi,
            'filter'    => $filter,
        ]);
    }

    public function print(Request $request)
    {
        $query  = $this->filterTransaksi($request);
        $filter = $this->filterAktif($request);

        $transaksi = (clone $query)->latest('tanggal_pinjam')->get();

        return view('report.print', $this->ringkasan($query) + [
            'transaksi' => $transaksi,
            'filter'    => $filter,
        ]);
    }
}