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
    ];

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
        return $this->kuota - $this->kuota_terisi;
    }
}
     * Get the reviews for the event.
     */
    public function reviews()
    {
        return $this->hasMany(EventReview::class);
    }
