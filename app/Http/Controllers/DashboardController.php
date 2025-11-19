<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderSummary;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk Admin dan Operator
     */
    public function index()
    {
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('login');
        }

        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalRevenue = OrderSummary::sum('subtotal');

        return view('dashboard.index', compact('user', 'totalOrders', 'totalProducts', 'totalRevenue'));
    }
}
