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
        'kuota_terisi',
        'status'
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

    /**
     * Get status label
     */
    public function getStatusLabel(): string
    {
        return $this->status === 'tersedia' ? 'Tersedia' : 'Selesai';
    }

    /**
     * Check if event is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'tersedia';
    }

    /**
     * Check if event has passed its date
     */
    public function hasEventPassed(): bool
    {
        return $this->tanggal_pelaksanaan < now();
    }

    /**
     * Update status based on event date
     */
    public function updateStatusBasedOnDate(): void
    {
        if ($this->hasEventPassed() && $this->status === 'tersedia') {
            $this->update(['status' => 'selesai']);
        }
    }
}
