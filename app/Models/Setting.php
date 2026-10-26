<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /**
     * Tabel key-value sederhana untuk pengaturan aplikasi.
     */
    protected $table = 'settings';

    protected $primaryKey = 'kunci';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['kunci', 'nilai'];

    /**
     * Ambil nilai pengaturan dengan cache.
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("settings:{$key}", function () use ($key, $default) {
            $row = static::query()->where('kunci', $key)->first();

            return $row->nilai ?? $default;
        });
    }

    /**
     * Simpan pengaturan dan bersihkan cache-nya.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['kunci' => $key], ['nilai' => $value]);

        Cache::forget("settings:{$key}");
    }
}