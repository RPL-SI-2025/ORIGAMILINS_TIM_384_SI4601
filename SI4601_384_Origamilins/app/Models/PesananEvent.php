<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananEvent extends Model
{
    use HasFactory;

    protected $table = 'pesanan_event';
    protected $primaryKey = 'id_pesanan_event';
    public $timestamps = true;

    protected $fillable = [
        'nama_pemesan',
        'nama_event',
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
} 