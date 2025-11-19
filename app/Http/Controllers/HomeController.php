<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Halaman utama untuk pelanggan (menampilkan menu)
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('home', compact('products', 'categories'));
    }
}
