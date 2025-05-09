<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

protected $fillable = [
    'order_id',
    'nama',
    'total',
    'status',
    'snap_token',
];
    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];
}