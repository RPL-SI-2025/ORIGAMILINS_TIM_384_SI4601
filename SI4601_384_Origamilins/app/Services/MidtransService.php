<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap Token for transaction
     *
     * @param array $params Transaction details
     * @return array Response from Midtrans API
     */
    public function getSnapToken($params)
    {
        try {
            $snapToken = Snap::getSnapToken($params);
            return [
                'success' => true,
                'token' => $snapToken,
                'redirect_url' => 'https://app.midtrans.com/snap/v2/vtweb/' . $snapToken,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Process notification from Midtrans
     *
     * @return Notification
     */
    public function processNotification()
    {
        try {
            // Return the notification object
            return new Notification();
        } catch (\Exception $e) {
            // Throw an exception to handle errors properly
            throw new \RuntimeException('Failed to process notification: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Check transaction status
     *
     * @param string $orderId Order ID
     * @return array Transaction status
     */
    public function checkTransactionStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            return [
                'success' => true,
                'status' => $status,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
