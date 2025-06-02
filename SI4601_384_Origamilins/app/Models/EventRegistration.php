<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'nama',
        'email',
        'telepon',
        'jumlah_tiket',
        'metode_pembayaran',
        'catatan',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}