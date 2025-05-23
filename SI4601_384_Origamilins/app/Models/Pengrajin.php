<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengrajin extends Model
{
    use HasFactory;

    protected $table = 'pengrajin';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'email',
        'is_active',
    ];

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
        return $this->hasMany(Pesanan::class, 'id_pengrajin', 'id')
                    ->where('status', 'selesai'); // status kecil semua, biasanya di DB
    }

    /**
     * Relasi semua pesanan ke pengrajin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_pengrajin', 'id');
    }
}
