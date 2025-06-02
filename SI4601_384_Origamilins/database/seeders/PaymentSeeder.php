<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payments;
use App\Models\User;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Get some random users
        $users = User::take(5)->get();
        
        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        // $paymentTypes = [
        //     'bank_transfer' => 'Transfer Bank',
        //     'credit_card' => 'Kartu Kredit',
        //     'e_wallet' => 'E-Wallet',
        //     'gopay' => 'GoPay',
        //     'shopeepay' => 'ShopeePay',
        //     'qris' => 'QRIS'
        // ];

        $statuses = [
            'pending' => 'Menunggu Pembayaran',
            'success' => 'Pembayaran Berhasil',
            'failed' => 'Pembayaran Gagal',
            'refund_requested' => 'Refund Diminta',
            'refunded' => 'Refund Diterima',
            'refund_rejected' => 'Refund Ditolak'
        ];

        // Create 20 sample payments
        for ($i = 1; $i <= 20; $i++) {
            $user = $users->random();
            // $paymentType = array_rand($paymentTypes);
            $status = array_rand($statuses);
            $total = rand(100000, 5000000);
            $createdAt = Carbon::now()->subDays(rand(1, 5));

            $payment = [
                'order_id' => 'ORD-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'nama' => $user->name,
                'total' => $total,
                // 'payment_type' => $paymentType,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            // Add refund information if status is refund related
            if ($status === 'refund_requested') {
                $payment['refund_reason'] = 'Produk tidak sesuai dengan deskripsi';
            } elseif ($status === 'refunded') {
                $payment['refunded_at'] = $createdAt->copy()->addDays(2);
            } elseif ($status === 'refund_rejected') {
                $payment['refund_rejected_at'] = $createdAt->copy()->addDays(1);
            }

            Payments::create($payment);
        }

        $this->command->info('Payment data seeded successfully!');
    }
} 