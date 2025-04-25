<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'rating',
        'komentar',
        'status'
    ];

    protected $attributes = [
        'status' => 'Menunggu'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getStatusOptions()
    {
        return [
            'Menunggu' => 'Menunggu',
            'Disetujui' => 'Disetujui',
            'Ditolak' => 'Ditolak'
        ];

        
    }
} 