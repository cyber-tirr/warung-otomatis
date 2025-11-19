@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-2" style="font-weight: 700; color: #1a1a1a;">
                    <i class="bi bi-speedometer2" style="color: #c9a961;"></i> Dashboard
                </h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-person-circle"></i> Selamat datang, <strong style="color: #c9a961;">{{ $user->name }}</strong> 
                    <span class="badge" style="background: linear-gradient(135deg, #1a1a1a, #2d2d2d); color: #c9a961;">
                        <i class="bi bi-shield-fill-check"></i> {{ ucfirst($user->role) }}
                    </span>
                </p>
            </div>
            <div>
                <span class="badge bg-light text-dark" style="font-size: 0.9rem; padding: 10px 16px;">
                    <i class="bi bi-calendar-event"></i> {{ now()->format('d F Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2" style="opacity: 0.9; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">
                            <i class="bi bi-cart-fill"></i> Total Pesanan
                        </h6>
                        <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $totalOrders }}</h1>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-receipt" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2" style="opacity: 0.9; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">
                            <i class="bi bi-cup-hot-fill"></i> Total Produk
                        </h6>
                        <h1 class="mb-0 fw-bold" style="font-size: 2.5rem;">{{ $totalProducts }}</h1>
                    </div>
                    <div style="background: rgba(255,255,255,0.2); border-radius: 50%; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-cup-hot" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card" style="background: linear-gradient(135deg, #c9a961 0%, #d4b574 100%); color: #1a1a1a; border: none;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-2" style="opacity: 0.9; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">
                            <i class="bi bi-cash-stack"></i> Total Pendapatan
                        </h6>
                        <h1 class="mb-0 fw-bold" style="font-size: 1.8rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h1>
                    </div>
                    <div style="background: rgba(0,0,0,0.1); border-radius: 50%; width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-wallet2" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card" style="border: 2px solid #e0e0e0;">
            <div class="card-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white;">
                <h5 class="mb-0"><i class="bi bi-lightning-charge-fill" style="color: #c9a961;"></i> Menu Cepat</h5>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <div class="row g-3">
                    @if($user->isAdmin())
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100 p-4 text-center">
                                <i class="bi bi-people-fill d-block mb-2" style="font-size: 2.5rem;"></i>
                                <strong>Kelola User</strong>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-success w-100 p-4 text-center">
                                <i class="bi bi-tags-fill d-block mb-2" style="font-size: 2.5rem;"></i>
                                <strong>Kelola Kategori</strong>
                            </a>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-warning w-100 p-4 text-center">
                            <i class="bi bi-cup-hot-fill d-block mb-2" style="font-size: 2.5rem;"></i>
                            <strong>Kelola Produk</strong>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info w-100 p-4 text-center">
                            <i class="bi bi-cart-check-fill d-block mb-2" style="font-size: 2.5rem;"></i>
                            <strong>Kelola Pesanan</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
