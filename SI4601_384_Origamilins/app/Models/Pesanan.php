<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'produk_id',
        'pengrajin_id',
        'jumlah',
        'total_harga',
        'status',
        'ekspedisi',
        'nomor_resi',
        'alamat_pengiriman',
        'nomor_telepon',
        'catatan',
        'tanggal_pesanan',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function pengrajin()
    {
        return $this->belongsTo(Pengrajin::class, 'pengrajin_id', 'id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // Status Options
    public static function getStatusOptions()
    {
        return [
            'Rencana' => 'Rencana',
            'Dalam Proses' => 'Dalam Proses',
            'Siap Dikirim' => 'Siap Dikirim',
            'Dikirim' => 'Dikirim',
            'Selesai' => 'Selesai',
            'Dibatalkan' => 'Dibatalkan'
        ];
    }

    // Ekspedisi Options
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

    // Scopes for filtering
    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Get status badge class
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Rencana' => 'bg-warning text-dark',
            'Dalam Proses' => 'bg-info text-white',
            'Siap Dikirim' => 'bg-primary text-white',
            'Dikirim' => 'bg-warning text-dark',
            'Selesai' => 'bg-success text-white',
            'Dibatalkan' => 'bg-danger text-white',
            default => 'bg-secondary text-white'
        };
    }

    // Get status badge class for payment
    public function getPaymentStatusBadgeAttribute()
    {
        return $this->status_pembayaran === 'Paid' ? 'bg-success text-white' : 'bg-danger text-white';
    }

    // Helper methods
    public function canBeAssigned()
    {
        return $this->status === 'Rencana';
    }

    public function canBeShipped()
    {
        return $this->status === 'Siap Dikirim' && $this->nomor_resi;
    }

    public function isInProgress()
    {
        return $this->status === 'Dalam Proses';
    }

    public function markAsInProgress()
    {
        $this->update([
            'status' => 'Dalam Proses',
            'tanggal_pesanan' => Carbon::now()
        ]);
    }

    public function markAsReadyToShip()
    {
        $this->update(['status' => 'Siap Dikirim']);
    }

    public function markAsShipped()
    {
        $this->update(['status' => 'Dikirim']);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'Selesai',
            'tanggal_selesai' => Carbon::now()
        ]);
    }
}
