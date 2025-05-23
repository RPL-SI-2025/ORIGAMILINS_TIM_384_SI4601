<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';
    
    protected $fillable = [
        'judul',
        'isi',
        'tanggal_publikasi',
        'gambar'
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime'
    ];
}
