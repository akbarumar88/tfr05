<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori
{
    // use HasFactory;

    private static $kategori = [
        [
            'id' => 1,
            'kategori' => 'Makanan'
        ],
        [
            'id' => 2,
            'kategori' => 'Minuman'
        ],
        [
            'id' => 3,
            'kategori' => 'Jajan'
        ],
    ];

    public static function all()
    {
        return collect(self::$kategori);
    }

    public static function find($id)
    {
        $kategori = static::all();
        return $kategori->firstWhere('id', $id);
    }
}
