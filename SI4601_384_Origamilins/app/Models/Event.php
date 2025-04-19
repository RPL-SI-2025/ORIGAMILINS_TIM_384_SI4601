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
        'poster'
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'datetime',
    ];

    /**
     * Get the reviews for the event.
     */
    public function reviews()
    {
        return $this->hasMany(EventReview::class);
    }
