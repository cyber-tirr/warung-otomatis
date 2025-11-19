<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Get cart data from session
     */
    public function getCart()
    {
        return response()->json([
            'cart' => session('cart', [])
        ]);
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $cart = session('cart', []);
        
        // Check if product already exists in cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image,
            ];
        }
        
        session(['cart' => $cart]);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart' => $cart
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = session('cart', []);
        
        if ($request->quantity == 0) {
            unset($cart[$request->product_id]);
        } else {
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] = $request->quantity;
            }
        }
        
        session(['cart' => $cart]);
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate',
            'cart' => $cart
        ]);
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang',
            'cart' => $cart
        ]);
    }

    /**
     * Clear cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }
}
