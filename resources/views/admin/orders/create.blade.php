@extends('layouts.dashboard')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-cart-plus-fill"></i> Buat Pesanan Baru</h2>
        <p class="text-muted">Isi data pelanggan dan pilih metode pembayaran</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-cart3"></i> Item Pesanan</h5>
                </div>
                <div class="card-body">
                    <div id="cartItemsDisplay">
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                            <p>Belum ada item di keranjang</p>
                            <a href="{{ route('home') }}" class="btn btn-primary" target="_blank">
                                <i class="bi bi-plus-circle"></i> Tambah Item dari Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Form -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-fill"></i> Data Pelanggan</h5>
                </div>
                <div class="card-body">
                    <form id="orderForm" action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="cart" id="cartData">

                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control" required 
                                   value="{{ old('customer_name') }}" placeholder="Masukkan nama pelanggan">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Meja <span class="text-danger">*</span></label>
                            <input type="text" name="table_number" class="form-control" required 
                                   value="{{ old('table_number') }}" placeholder="Contoh: 1, 2, A1, B2, dll">
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="payment_cash" value="cash" checked>
                                <label class="form-check-label" for="payment_cash">
                                    <i class="bi bi-cash-coin text-success"></i> <strong>Tunai (Cash)</strong>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="payment_later" value="later">
                                <label class="form-check-label" for="payment_later">
                                    <i class="bi bi-clock-history text-warning"></i> <strong>Bayar Nanti</strong>
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_status" 
                                       id="payment_success" value="success" checked>
                                <label class="form-check-label" for="payment_success">
                                    <i class="bi bi-check-circle-fill text-success"></i> <strong>Sudah Dibayar</strong>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_status" 
                                       id="payment_pending" value="pending">
                                <label class="form-check-label" for="payment_pending">
                                    <i class="bi bi-hourglass-split text-warning"></i> <strong>Belum Dibayar</strong>
                                </label>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Total Pembayaran:</h5>
                            <h4 class="mb-0 text-primary" id="totalAmount">Rp 0</h4>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                <i class="bi bi-check-circle"></i> Proses Pesanan
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
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
    
    // Update cart display
    function updateCartDisplay() {
        const cartItemsDisplay = document.getElementById('cartItemsDisplay');
        const totalAmount = document.getElementById('totalAmount');
        const submitBtn = document.getElementById('submitBtn');
        const cartData = document.getElementById('cartData');
        
        if (cart.length === 0) {
            cartItemsDisplay.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
                    <p>Belum ada item di keranjang</p>
                    <a href="{{ route('home') }}" class="btn btn-primary" target="_blank">
                        <i class="bi bi-plus-circle"></i> Tambah Item dari Menu
                    </a>
                </div>
            `;
            totalAmount.textContent = 'Rp 0';
            submitBtn.disabled = true;
            return;
        }
        
        let itemsHtml = '<div class="table-responsive"><table class="table table-hover">';
        itemsHtml += '<thead><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead><tbody>';
        
        let total = 0;
        
        cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            itemsHtml += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            ${item.image ? 
                                '<img src="' + item.image + '" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;" alt="' + item.name + '">' :
                                '<div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;"><i class="bi bi-cup-hot-fill text-white"></i></div>'
                            }
                            <strong>${item.name}</strong>
                        </div>
                    </td>
                    <td>Rp ${formatNumber(item.price)}</td>
                    <td>
                        <div class="input-group input-group-sm" style="width: 120px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(${item.id}, -1)">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="text" class="form-control text-center" value="${item.quantity}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(${item.id}, 1)">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </td>
                    <td><strong class="text-primary">Rp ${formatNumber(itemTotal)}</strong></td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        
        itemsHtml += '</tbody></table></div>';
        
        cartItemsDisplay.innerHTML = itemsHtml;
        totalAmount.textContent = 'Rp ' + formatNumber(total);
        submitBtn.disabled = false;
        
        // Update hidden cart data for form submission
        cartData.value = JSON.stringify(cart);
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
    
    // Remove item from cart
    function removeFromCart(productId) {
        if (confirm('Hapus item ini dari keranjang?')) {
            cart = cart.filter(item => item.id !== productId);
            saveCart();
            updateCartDisplay();
        }
    }
    
    // Save cart to localStorage
    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    // Format number to Indonesian currency
    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
    
    // Form submission handler
    let isSubmitting = false;
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        // Prevent double submit
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }
        
        if (cart.length === 0) {
            e.preventDefault();
            alert('Keranjang masih kosong! Silakan tambahkan item terlebih dahulu.');
            return false;
        }
        
        // Make sure cartData is updated before submit
        const cartData = document.getElementById('cartData');
        cartData.value = JSON.stringify(cart);
        
        console.log('Submitting cart:', cart);
        console.log('Cart data value:', cartData.value);
        
        // Set flag and disable submit button
        isSubmitting = true;
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';
    });
    
    // Load cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadCart();
        
        // Auto refresh cart every 2 seconds to sync with localStorage
        setInterval(function() {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                const newCart = JSON.parse(savedCart);
                if (JSON.stringify(cart) !== JSON.stringify(newCart)) {
                    cart = newCart;
                    updateCartDisplay();
                }
            }
        }, 2000);
    });
</script>
@endpush
@endsection
