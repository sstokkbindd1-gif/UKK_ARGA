<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $primaryKey = 'id_buku';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'cover',
        'jumlah_stok',
    ];

    /**
     * Relasi ke tabel transaksi
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_buku', 'id_buku');
    }
}