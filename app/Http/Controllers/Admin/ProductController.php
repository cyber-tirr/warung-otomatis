<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['category_id', 'name', 'description', 'price']);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Ensure directory exists
            $directory = storage_path('app/public/products');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Move file directly
            $file->move($directory, $filename);
            $data['image'] = 'products/' . $filename;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['category_id', 'name', 'description', 'price']);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Hapus gambar lama
            if ($product->image) {
                $oldImagePath = storage_path('app/public/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Ensure directory exists
            $directory = storage_path('app/public/products');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Move file directly
            $file->move($directory, $filename);
            $data['image'] = 'products/' . $filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            $imagePath = storage_path('app/public/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
