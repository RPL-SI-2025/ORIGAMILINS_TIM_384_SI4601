<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = true;

    protected $fillable = [
        'nama_pemesan',
        'nama_produk',
        'ekspedisi',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public static function getStatusOptions()
    {
        return [
            'Menunggu' => 'Menunggu',
            'Dikonfirmasi' => 'Dikonfirmasi',
            'Selesai' => 'Selesai',
            'Dibatalkan' => 'Dibatalkan'
        ];
    }

    public static function getEkspedisiOptions()
    {
        return [
            'JNE' => 'JNE',
            'J&T' => 'J&T',
            'SiCepat' => 'SiCepat',
            'Pos Indonesia' => 'Pos Indonesia',
            'TIKI' => 'TIKI'
        ];
    }
} 