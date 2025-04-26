<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengrajin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

        /**
     * Relasi ke pesanan yang telah diselesaikan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function completedOrders()
    {
        return $this->hasMany(Pesanan::class, 'id_pesanan', 'id')
                    ->where('status', 'Selesai'); // Hanya pesanan status "Selesai"
    }
}