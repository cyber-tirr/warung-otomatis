<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderSummary;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Services\MidtransService;
use App\Events\NewOrderCreated;

class OrderController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Simpan pesanan dari pelanggan
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:cash,midtrans',
        ]);

        try {
            DB::beginTransaction();

            // Cari atau buat customer
            $customer = Customer::firstOrCreate(
                ['phone' => $request->customer_phone],
                [
                    'name' => $request->customer_name,
                    'address' => $request->customer_address,
                ]
            );

            // Ambil produk
            $product = Product::findOrFail($request->product_id);
            $totalPrice = $product->price * $request->quantity;

            // Buat order
            $order = Order::create([
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Buat order summary
            OrderSummary::create([
                'order_id' => $order->id,
                'subtotal' => $totalPrice,
            ]);

            // Proses pembayaran
            if ($request->payment_method === 'midtrans') {
                $midtransResult = $this->midtransService->createTransaction($order, $customer);

                if ($midtransResult['success']) {
                    Payment::create([
                        'order_id' => $order->id,
                        'payment_method' => 'midtrans',
                        'transaction_id' => $midtransResult['transaction_id'],
                        'amount' => $totalPrice,
                        'status' => 'pending',
                        'payment_data' => ['snap_token' => $midtransResult['snap_token']],
                    ]);

                    DB::commit();

                    // Broadcast event untuk notifikasi real-time
                    event(new NewOrderCreated($order));

                    return redirect()->route('payment.show', $order->id);
                } else {
                    DB::rollBack();
                    return back()->with('error', 'Gagal membuat transaksi pembayaran: ' . $midtransResult['message']);
                }
            } else {
                // Pembayaran cash
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => 'cash',
                    'amount' => $totalPrice,
                    'status' => 'pending',
                ]);

                DB::commit();

                // Broadcast event untuk notifikasi real-time
                event(new NewOrderCreated($order));

                return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat! Silakan bayar di kasir. Terima kasih.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showPayment($orderId)
    {
        $order = Order::with(['customer', 'product', 'payment'])->findOrFail($orderId);

        if (!$order->payment || $order->payment->payment_method !== 'midtrans') {
            return redirect()->route('home')->with('error', 'Halaman pembayaran tidak tersedia.');
        }

        return view('payment', compact('order'));
    }

    public function paymentCallback(Request $request)
    {
        $transactionId = $request->order_id;
        $payment = Payment::where('transaction_id', $transactionId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $statusResult = $this->midtransService->getTransactionStatus($transactionId);

        if ($statusResult['success']) {
            $status = $statusResult['data'];
            
            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                ]);
                $payment->order->update(['status' => 'processed']);
            } elseif ($status->transaction_status == 'pending') {
                $payment->update(['status' => 'pending']);
            } elseif (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
                $payment->update(['status' => 'failed']);
                $payment->order->update(['status' => 'cancelled']);
            }
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
