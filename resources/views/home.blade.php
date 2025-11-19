@extends('layouts.app')

@section('title', 'Menu Warung Kopi')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%); box-shadow: 0 4px 20px rgba(0,0,0,0.3); border-bottom: 2px solid #c9a961;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}" style="font-weight: 700; font-size: 1.4rem; color: #ffffff; text-shadow: 0 2px 10px rgba(201, 169, 97, 0.3);">
            <i class="bi bi-cup-hot-fill" style="color: #c9a961; filter: drop-shadow(0 0 8px rgba(201, 169, 97, 0.5));"></i> Warung Kopi Otomatis
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <button class="btn position-relative" id="cartBtn" data-bs-toggle="modal" data-bs-target="#cartModal" style="background: linear-gradient(135deg, #c9a961, #d4b574); color: #1a1a1a; font-weight: 700; border-radius: 10px; padding: 10px 20px; border: none; transition: all 0.3s ease;">
                <i class="bi bi-cart3"></i> Keranjang
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount" style="display: none;">
                    0
                </span>
            </button>
            <a href="{{ route('login') }}" class="btn" style="background: linear-gradient(135deg, #c9a961, #d4b574); color: #1a1a1a; font-weight: 700; border-radius: 10px; padding: 10px 24px; border: none; transition: all 0.3s ease;">
                <i class="bi bi-box-arrow-in-right"></i> Login Admin/Operator
            </a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-3 fw-bold" style="color: #1a1a1a;">
            <i class="bi bi-cup-hot-fill" style="color: #c9a961; filter: drop-shadow(0 0 10px rgba(201, 169, 97, 0.4));"></i> Menu Kami
        </h1>
        <p class="lead" style="color: #6c757d; font-size: 1.2rem;">Pilih menu favorit Anda dan pesan sekarang!</p>
        <div style="width: 100px; height: 4px; background: linear-gradient(90deg, #c9a961, #d4b574); margin: 20px auto; border-radius: 2px;"></div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle"></i> Belum ada menu tersedia saat ini.
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm product-card" style="cursor: pointer;" 
                         data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                        <div class="position-relative">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="card-img-top" alt="{{ $product->name }}" 
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="bi bi-cup-hot-fill text-white" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                {{ $product->category->name }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">
                                {{ Str::limit($product->description, 60) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <button class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Lihat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Produk -->
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $product->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="img-fluid rounded mb-3" alt="{{ $product->name }}">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded mb-3" 
                                         style="height: 250px;">
                                        <i class="bi bi-cup-hot-fill text-white" style="font-size: 5rem;"></i>
                                    </div>
                                @endif
                                
                                <p class="text-muted">{{ $product->description }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary">{{ $product->category->name }}</span>
                                    <span class="h4 mb-0 text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQty{{ $product->id }}()">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="number" class="form-control text-center" id="qty{{ $product->id }}" value="1" min="1" readonly>
                                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQty{{ $product->id }}()">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-primary w-100" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image ? asset('storage/' . $product->image) : '' }}')">
                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function decreaseQty{{ $product->id }}() {
                        let qty = document.getElementById('qty{{ $product->id }}');
                        if (qty.value > 1) {
                            qty.value = parseInt(qty.value) - 1;
                        }
                    }
                    
                    function increaseQty{{ $product->id }}() {
                        let qty = document.getElementById('qty{{ $product->id }}');
                        qty.value = parseInt(qty.value) + 1;
                    }
                </script>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
    }
    
    .product-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }
    
    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #c9a961, #d4b574);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }
    
    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 50px rgba(0,0,0,0.2) !important;
    }
    
    .product-card:hover::before {
        opacity: 1;
    }
    
    .card-img-top {
        transition: transform 0.4s ease;
    }
    
    .product-card:hover .card-img-top {
        transform: scale(1.1);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #c9a961, #d4b574);
        border: none;
        color: #1a1a1a;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #d4b574, #c9a961);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(201, 169, 97, 0.3);
        color: #000000;
    }
    
    .badge.bg-primary {
        background: linear-gradient(135deg, #1a1a1a, #2d2d2d) !important;
        color: #c9a961;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 8px;
    }
    
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 20px 24px;
    }
    
    .form-control, .form-check-input {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #c9a961;
        box-shadow: 0 0 0 0.2rem rgba(201, 169, 97, 0.15);
    }
    
    .form-label {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .cart-item {
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 0;
        transition: background-color 0.3s ease;
    }
    
    .cart-item:hover {
        background-color: #f8f9fa;
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
</style>
@endpush

<!-- Modal Keranjang -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-cart3"></i> Keranjang Belanja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="cartItems">
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                        <p>Keranjang masih kosong</p>
                    </div>
                </div>
                <div id="cartSummary" style="display: none;">
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Total:</h5>
                        <h4 class="mb-0 text-primary" id="cartTotal">Rp 0</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="cartFooter" style="display: none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" onclick="clearCart()">
                    <i class="bi bi-trash"></i> Kosongkan Keranjang
                </button>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Login untuk Proses Pesanan
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cart = [];
    
    // Load cart from localStorage
    function loadCart() {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            cart = JSON.parse(savedCart);
            updateCartDisplay();
        }
    }
    
    // Save cart to localStorage
    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    // Add item to cart
    function addToCart(productId, productName, productPrice, productImage) {
        const qty = parseInt(document.getElementById('qty' + productId).value);
        
        // Check if item already exists in cart
        const existingItem = cart.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += qty;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: qty
            });
        }
        
        saveCart();
        updateCartDisplay();
        
        // Close product modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('productModal' + productId));
        if (modal) {
            modal.hide();
        }
        
        // Show success message
        showToast('Produk berhasil ditambahkan ke keranjang!');
    }
    
    // Remove item from cart
    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        saveCart();
        updateCartDisplay();
        showToast('Produk dihapus dari keranjang');
    }
    
    // Update item quantity
    function updateQuantity(productId, change) {
        const item = cart.find(item => item.id === productId);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                removeFromCart(productId);
            } else {
                saveCart();
                updateCartDisplay();
            }
        }
    }
    
    // Clear cart
    function clearCart() {
        if (confirm('Yakin ingin mengosongkan keranjang?')) {
            cart = [];
            saveCart();
            updateCartDisplay();
            showToast('Keranjang telah dikosongkan');
        }
    }
    
    // Update cart display
    function updateCartDisplay() {
        const cartCount = document.getElementById('cartCount');
        const cartItems = document.getElementById('cartItems');
        const cartSummary = document.getElementById('cartSummary');
        const cartFooter = document.getElementById('cartFooter');
        const cartTotal = document.getElementById('cartTotal');
        
        // Update cart count badge
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        if (totalItems > 0) {
            cartCount.textContent = totalItems;
            cartCount.style.display = 'inline-block';
        } else {
            cartCount.style.display = 'none';
        }
        
        // Update cart items display
        if (cart.length === 0) {
            cartItems.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                    <p>Keranjang masih kosong</p>
                </div>
            `;
            cartSummary.style.display = 'none';
            cartFooter.style.display = 'none';
        } else {
            let itemsHtml = '';
            let total = 0;
            
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                
                itemsHtml += `
                    <div class="cart-item">
                        <div class="row align-items-center">
                            <div class="col-2">
                                ${item.image ? 
                                    '<img src="' + item.image + '" class="img-fluid rounded" alt="' + item.name + '">' :
                                    '<div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 60px;"><i class="bi bi-cup-hot-fill text-white"></i></div>'
                                }
                            </div>
                            <div class="col-4">
                                <h6 class="mb-0">${item.name}</h6>
                                <small class="text-muted">Rp ${formatNumber(item.price)}</small>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(${item.id}, -1)">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(${item.id}, 1)">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-2 text-end">
                                <strong class="text-primary">Rp ${formatNumber(itemTotal)}</strong>
                            </div>
                            <div class="col-1 text-end">
                                <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            cartItems.innerHTML = itemsHtml;
            cartTotal.textContent = 'Rp ' + formatNumber(total);
            cartSummary.style.display = 'block';
            cartFooter.style.display = 'flex';
        }
    }
    
    // Format number to Indonesian currency
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
    
    // Show toast notification
    function showToast(message) {
        // Create toast element
        const toastHtml = `
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11000">
                <div class="toast show" role="alert">
                    <div class="toast-header">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <strong class="me-auto">Notifikasi</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            </div>
        `;
        
        const toastContainer = document.createElement('div');
        toastContainer.innerHTML = toastHtml;
        document.body.appendChild(toastContainer);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            toastContainer.remove();
        }, 3000);
    }
    
    // Load cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
    });
</script>
@endpush
@endsection
