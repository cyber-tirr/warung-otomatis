<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Models\Payment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all orders that don't have payment records
        $ordersWithoutPayment = Order::doesntHave('payment')->get();
        
        foreach ($ordersWithoutPayment as $order) {
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'cash', // Default to cash for old orders
                'amount' => $order->total_price,
                'status' => 'pending', // Default to pending
                'paid_at' => null,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
        // as it only adds missing data
    }
};
