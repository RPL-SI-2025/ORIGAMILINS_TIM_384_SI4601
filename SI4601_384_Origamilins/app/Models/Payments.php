<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'total',
        'nama',
        'status',
        'refund_reason',
        'refunded_at',
        'refund_rejected_at',
        'refund_metadata',
        'snap_token',
        'payment_type',
        'transaction_id',
        'metadata'
    ];

    protected $casts = [
        'refunded_at' => 'datetime',
        'paid_at' => 'datetime',
        'refund_rejected_at' => 'datetime',
        'refund_metadata' => 'array',
        'metadata' => 'array'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUND_REQUESTED = 'refund_requested';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_REFUND_REJECTED = 'refund_rejected';

    // Scope for refund requests
    public function scopeRefundRequests($query)
    {
        return $query->where('status', self::STATUS_REFUND_REQUESTED);
    }
    // Scope for processed refunds
    public function scopeProcessedRefunds($query)
    {
        return $query->whereIn('status', [
            self::STATUS_REFUNDED,
            self::STATUS_REFUND_REJECTED
        ]);
    }
}