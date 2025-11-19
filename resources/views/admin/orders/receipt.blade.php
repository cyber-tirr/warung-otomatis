@extends('layouts.dashboard')

@section('title', 'Struk Pesanan')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center no-print">
        <div>
            <h2><i class="bi bi-receipt"></i> Struk Pesanan</h2>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Cetak Struk
            </button>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Receipt -->
    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="receipt-wrapper">
                <div id="receipt">
                    <!-- Header -->
                    <div class="receipt-header">
                        <div class="store-icon">☕</div>
                        <h1 class="store-name">WARKOP HEMAT</h1>
                        <div class="store-info">
                            <p>Jl. Ramayana. 09, Cianjur</p>
                            <p>Telp: 080709398202</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Order Info -->
                    <div class="receipt-section">
                        <div class="info-row">
                            <span>No. Transaksi</span>
                            <span class="bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="info-row">
                            <span>Tanggal</span>
                            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span>Pelanggan</span>
                            <span>{{ $order->customer->name }}</span>
                        </div>
                        <div class="info-row">
                            <span>Meja</span>
                            <span class="bold">{{ $order->customer->table_number ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Order Items -->
                    <div class="receipt-section">
                        <table class="items-table">
                            @php
                                $grandTotal = 0;
                            @endphp
                            @foreach($relatedOrders as $item)
                                @php
                                    $grandTotal += $item->total_price;
                                @endphp
                                <tr class="item-row">
                                    <td colspan="3" class="item-name">{{ $item->product->name }}</td>
                                </tr>
                                <tr class="item-detail">
                                    <td class="item-qty">{{ $item->quantity }} x</td>
                                    <td class="item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td class="item-subtotal">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <div class="divider"></div>

                    <!-- Total -->
                    <div class="receipt-section">
                        <div class="total-row">
                            <span class="total-label">TOTAL</span>
                            <span class="total-amount">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Payment Info -->
                    <div class="receipt-section">
                        @if($order->payment)
                            <div class="info-row">
                                <span>Metode</span>
                                <span class="bold">
                                    @if($order->payment->payment_method === 'cash')
                                        TUNAI
                                    @elseif($order->payment->payment_method === 'later')
                                        BAYAR NANTI
                                    @else
                                        {{ strtoupper($order->payment->payment_method) }}
                                    @endif
                                </span>
                            </div>
                            <div class="info-row">
                                <span>Status</span>
                                <span class="bold">
                                    @if($order->payment->status === 'success')
                                        ✓ LUNAS
                                    @elseif($order->payment->status === 'pending')
                                        ⏱ BELUM LUNAS
                                    @else
                                        ✗ GAGAL
                                    @endif
                                </span>
                            </div>
                            @if($order->payment->payment_method === 'cash' && $order->payment->cash_paid)
                                <div class="divider-thin"></div>
                                <div class="info-row">
                                    <span>Uang Dibayar</span>
                                    <span class="bold">Rp {{ number_format($order->payment->cash_paid, 0, ',', '.') }}</span>
                                </div>
                                <div class="info-row">
                                    <span>Kembalian</span>
                                    <span class="bold">Rp {{ number_format($order->payment->change_amount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @if($order->payment->paid_at)
                                <div class="info-row small">
                                    <span colspan="2">Dibayar: {{ $order->payment->paid_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="divider"></div>

                    <!-- Status -->
                    <div class="receipt-section">
                        <div class="status-badge">
                            @if($order->status === 'pending')
                                ⏱ PENDING
                            @elseif($order->status === 'processed')
                                🔄 DIPROSES
                            @elseif($order->status === 'completed')
                                ✓ SELESAI
                            @else
                                ✗ DIBATALKAN
                            @endif
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- Footer -->
                    <div class="receipt-footer">
                        <p class="thank-you">Terima Kasih!</p>
                        <p class="enjoy">Selamat Menikmati Dan Datang Kembali Yaaaaa</p>
                        <p class="print-time">{{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Screen View */
    .receipt-wrapper {
        background: #f5f5f5;
        padding: 20px;
        border-radius: 8px;
    }

    #receipt {
        background: white;
        padding: 20px;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        line-height: 1.4;
        color: #000;
        max-width: 300px;
        margin: 0 auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 10px;
    }

    .store-icon {
        font-size: 32px;
        margin-bottom: 5px;
    }

    .store-name {
        font-size: 16px;
        font-weight: bold;
        margin: 5px 0;
        letter-spacing: 0.5px;
    }

    .store-info {
        font-size: 11px;
        line-height: 1.3;
    }

    .store-info p {
        margin: 2px 0;
    }

    .divider {
        border-top: 1px dashed #000;
        margin: 10px 0;
    }

    .divider-thin {
        border-top: 1px dotted #999;
        margin: 5px 0;
    }

    .receipt-section {
        margin: 10px 0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin: 3px 0;
        font-size: 12px;
    }

    .info-row.small {
        font-size: 10px;
    }

    .bold {
        font-weight: bold;
    }

    .items-table {
        width: 100%;
        font-size: 12px;
    }

    .item-row td {
        padding-top: 8px;
    }

    .item-name {
        font-weight: bold;
    }

    .item-detail td {
        padding: 2px 0;
    }

    .item-qty {
        width: 25%;
    }

    .item-price {
        width: 40%;
    }

    .item-subtotal {
        width: 35%;
        text-align: right;
        font-weight: bold;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        font-weight: bold;
        padding: 5px 0;
    }

    .total-amount {
        font-size: 16px;
    }

    .status-badge {
        text-align: center;
        font-weight: bold;
        font-size: 13px;
        padding: 5px;
        background: #f0f0f0;
        border-radius: 4px;
    }

    .receipt-footer {
        text-align: center;
        font-size: 11px;
    }

    .thank-you {
        font-weight: bold;
        font-size: 13px;
        margin: 5px 0;
    }

    .enjoy {
        margin: 3px 0;
    }

    .print-time {
        font-size: 9px;
        color: #666;
        margin-top: 8px;
    }

    /* Print Styles */
    @media print {
        body {
            margin: 0;
            padding: 0;
        }

        body * {
            visibility: hidden;
        }
        
        #receipt, #receipt * {
            visibility: visible;
        }
        
        .no-print {
            display: none !important;
        }

        .receipt-wrapper {
            background: none;
            padding: 0;
            box-shadow: none;
        }
        
        #receipt {
            position: absolute;
            left: 50%;
            top: 0;
            transform: translateX(-50%);
            width: 80mm !important;
            max-width: 80mm !important;
            margin: 0;
            padding: 10mm;
            box-shadow: none;
            font-size: 12px;
        }

        .store-icon {
            font-size: 28px;
        }

        .store-name {
            font-size: 14px;
        }

        .store-info {
            font-size: 10px;
        }

        .info-row {
            font-size: 11px;
        }

        .items-table {
            font-size: 11px;
        }

        .total-row {
            font-size: 13px;
        }

        .total-amount {
            font-size: 15px;
        }

        .receipt-footer {
            font-size: 10px;
        }

        .thank-you {
            font-size: 12px;
        }

        .print-time {
            font-size: 8px;
        }
        
        @page {
            size: 80mm auto;
            margin: 0;
        }
    }
</style>
@endpush
@endsection
