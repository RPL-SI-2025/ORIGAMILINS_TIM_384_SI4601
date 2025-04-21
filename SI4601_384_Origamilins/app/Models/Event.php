<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
        'nama_event',
        'deskripsi',
        'tanggal_pelaksanaan',
        'harga',
        'lokasi',
        'poster',
        'kuota',
        'kuota_terisi'
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'datetime',
        'harga' => 'decimal:2',
        'kuota' => 'integer',
        'kuota_terisi' => 'integer'
    ];

    /**
     * Get the reviews for the event.
     */
    public function reviews()
    {
        return $this->hasMany(EventReview::class);
    }

    /**
     * Check if event still has available seats
     */
    public function hasAvailableSeats(): bool
    {
        return $this->kuota > $this->kuota_terisi;
    }

    /**
     * Get remaining seats
     */
    public function getRemainingSeats(): int
    {
        return max(0, $this->kuota - $this->kuota_terisi);
    }
}
