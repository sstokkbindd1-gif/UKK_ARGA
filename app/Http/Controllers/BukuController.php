<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Menampilkan semua data buku
     */
    public function index()
    {
        $buku = Buku::latest()->get();

        return view('buku.index', compact('buku'));
    }


    /**
     * Menampilkan form tambah buku
     */
    public function create()
    {
        return view('buku.create');
    }


    /**
     * Menyimpan buku baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'nullable',
            'tahun_terbit' => 'nullable|integer',
            'kategori' => 'nullable',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah_stok' => 'nullable|integer|min:0',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        Buku::create([
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori' => $request->kategori,
            'cover' => $coverPath,
            'jumlah_stok' => $request->jumlah_stok,
        ]);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }


    /**
     * Menampilkan detail buku
     */
    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);

        return view('buku.show', compact('buku'));
    }


    /**
     * Menampilkan form edit
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);

        return view('buku.edit', compact('buku'));
    }


    /**
     * Memperbarui data buku
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'nullable',
            'tahun_terbit' => 'nullable|integer',
            'kategori' => 'nullable',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'jumlah_stok' => 'nullable|integer|min:0',
        ]);

        $buku = Buku::findOrFail($id);

        $coverPath = $buku->cover;
        if ($request->hasFile('cover')) {
            // Hapus file lama jika ada
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            // Simpan file baru
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $buku->update([
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'kategori' => $request->kategori,
            'cover' => $coverPath,
            'jumlah_stok' => $request->jumlah_stok,
        ]);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }


    /**
     * Menghapus buku
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus file cover jika ada
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}