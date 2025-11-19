<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction($order, $customer)
    {
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $customer->address,
            ],
            'item_details' => [
                [
                    'id' => $order->product->id,
                    'price' => (int) $order->product->price,
                    'quantity' => $order->quantity,
                    'name' => $order->product->name,
                ]
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return [
                'success' => true,
                'snap_token' => $snapToken,
                'transaction_id' => $params['transaction_details']['order_id'],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getTransactionStatus($transactionId)
    {
        try {
            $status = \Midtrans\Transaction::status($transactionId);
            return [
                'success' => true,
                'data' => $status,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
