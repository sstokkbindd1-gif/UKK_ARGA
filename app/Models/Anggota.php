<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $primaryKey = 'id_anggota';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'nis',
        'nama_lengkap',
        'alamat',
        'kelas',
    ];


    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}