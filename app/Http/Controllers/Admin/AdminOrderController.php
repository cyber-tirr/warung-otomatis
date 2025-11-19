<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderSummary;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'product', 'payment'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'product', 'summary', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show form to create order from cart
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store order from admin/operator
     */
    public function store(Request $request)
    {
        // Decode cart JSON if it's a string
        $cartData = $request->cart;
        if (is_string($cartData)) {
            $cartData = json_decode($cartData, true);
        }
        
        // Log cart data for debugging
        \Log::info('Creating order with cart data:', [
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'cart_items' => count($cartData),
            'cart_data' => $cartData
        ]);
        
        // Replace cart in request with decoded data
        $request->merge(['cart' => $cartData]);
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|string|max:20',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,later',
            'payment_status' => 'required|in:pending,success',
        ]);

        try {
            DB::beginTransaction();

            // Create customer (always create new for each order)
            $customer = Customer::create([
                'name' => $request->customer_name,
                'table_number' => $request->table_number,
            ]);

            $orders = [];
            $totalAmount = 0;
            $processedItems = []; // Track processed items to prevent duplicates

            // Create orders for each cart item
            foreach ($cartData as $item) {
                // Skip if item already processed (prevent duplicates)
                $itemKey = $item['id'] . '_' . $item['quantity'];
                if (in_array($itemKey, $processedItems)) {
                    continue;
                }
                $processedItems[] = $itemKey;
                $product = Product::findOrFail($item['id']);
                $totalPrice = $product->price * $item['quantity'];
                $totalAmount += $totalPrice;

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'total_price' => $totalPrice,
                    'status' => $request->payment_status === 'success' ? 'processed' : 'pending',
                ]);

                // Create order summary
                OrderSummary::create([
                    'order_id' => $order->id,
                    'subtotal' => $totalPrice,
                ]);

                // Create payment record
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method' => $request->payment_method,
                    'amount' => $totalPrice,
                    'status' => $request->payment_status,
                    'paid_at' => $request->payment_status === 'success' ? now() : null,
                ]);

                $orders[] = $order;
            }

            DB::commit();

            // Clear cart from session
            session()->forget('cart');

            // Redirect to payment confirmation page for cash payment
            if ($request->payment_method === 'cash') {
                return redirect()->route('admin.orders.payment-confirmation', $orders[0]->id)
                    ->with('success', 'Pesanan berhasil dibuat! Silakan input pembayaran.');
            }

            // For non-cash payment, go directly to receipt
            return redirect()->route('admin.orders.receipt', $orders[0]->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show payment confirmation page
     */
    public function paymentConfirmation($orderId)
    {
        $order = Order::with(['customer', 'product', 'payment'])->findOrFail($orderId);
        
        // Get all orders from the same customer with same timestamp (batch order)
        $relatedOrders = Order::with(['product', 'payment'])
            ->where('customer_id', $order->customer_id)
            ->whereBetween('created_at', [
                $order->created_at->copy()->subSeconds(5),
                $order->created_at->copy()->addSeconds(5)
            ])
            ->get();

        return view('admin.orders.payment-confirmation', compact('order', 'relatedOrders'));
    }

    /**
     * Process payment and redirect to receipt
     */
    public function processPayment(Request $request, $orderId)
    {
        $order = Order::with(['customer', 'payment'])->findOrFail($orderId);
        
        // Get all related orders
        $relatedOrders = Order::with(['product', 'payment'])
            ->where('customer_id', $order->customer_id)
            ->whereBetween('created_at', [
                $order->created_at->copy()->subSeconds(5),
                $order->created_at->copy()->addSeconds(5)
            ])
            ->get();

        $totalAmount = $request->total_amount;
        $cashPaid = $request->cash_paid;
        $changeAmount = $cashPaid - $totalAmount;

        // Validate cash paid
        if ($cashPaid < $totalAmount) {
            return back()->with('error', 'Uang yang dibayarkan kurang dari total pembayaran!')->withInput();
        }

        try {
            DB::beginTransaction();

            // Update all related payments
            foreach ($relatedOrders as $relatedOrder) {
                if ($relatedOrder->payment) {
                    $relatedOrder->payment->update([
                        'cash_paid' => $cashPaid,
                        'change_amount' => $changeAmount,
                        'status' => 'success',
                        'paid_at' => now(),
                    ]);
                }

                // Update order status to processed
                $relatedOrder->update(['status' => 'processed']);
            }

            DB::commit();

            return redirect()->route('admin.orders.receipt', $order->id)
                ->with('success', 'Pembayaran berhasil diproses!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show receipt
     */
    public function receipt($orderId)
    {
        $order = Order::with(['customer', 'product', 'payment'])->findOrFail($orderId);
        
        // Get all orders from the same customer with same timestamp (batch order)
        $relatedOrders = Order::with(['product', 'payment'])
            ->where('customer_id', $order->customer_id)
            ->whereBetween('created_at', [
                $order->created_at->copy()->subSeconds(5),
                $order->created_at->copy()->addSeconds(5)
            ])
            ->get();

        return view('admin.orders.receipt', compact('order', 'relatedOrders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diupdate.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
