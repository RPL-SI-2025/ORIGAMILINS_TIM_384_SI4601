<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

<<<<<<< Updated upstream
=======
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
>>>>>>> Stashed changes
    protected $fillable = [
        'nama',
        'harga',
        'kategori',
        'deskripsi',
<<<<<<< Updated upstream
        'gambar',
=======
        'gambar'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'decimal:2'
>>>>>>> Stashed changes
    ];
}
