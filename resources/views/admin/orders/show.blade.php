@extends('layouts.dashboard')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-receipt"></i> Detail Pesanan #{{ $order->id }}</h2>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong><i class="bi bi-cup-hot-fill text-warning"></i> Produk:</strong><br>
                            {{ $order->product->name }}
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-tag-fill"></i> Kategori:</strong><br>
                            <span class="badge bg-primary"><i class="bi bi-tag"></i> {{ $order->product->category->name }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong><i class="bi bi-hash"></i> Jumlah:</strong><br>
                            <span class="badge bg-secondary">{{ $order->quantity }}x</span>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-tag"></i> Harga Satuan:</strong><br>
                            <span class="text-muted">Rp {{ number_format($order->product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong><i class="bi bi-cash-stack"></i> Total Harga:</strong><br>
                            <span class="h5 text-success"><i class="bi bi-cash-coin"></i> Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong><i class="bi bi-info-circle"></i> Status:</strong><br>
                            @if($order->status === 'pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock-history"></i> Pending
                                </span>
                            @elseif($order->status === 'processed')
                                <span class="badge bg-info">
                                    <i class="bi bi-hourglass-split"></i> Diproses
                                </span>
                            @elseif($order->status === 'completed')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill"></i> Selesai
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle-fill"></i> Dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <strong><i class="bi bi-calendar-event"></i> Tanggal Pesanan:</strong><br>
                            <i class="bi bi-clock"></i> {{ $order->created_at->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-fill"></i> Informasi Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong><i class="bi bi-person-circle text-primary"></i> Nama:</strong><br>
                            {{ $order->customer->name }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong><i class="bi bi-table text-success"></i> Nomor Meja:</strong><br>
                            <span class="badge bg-primary fs-6">{{ $order->customer->table_number ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
