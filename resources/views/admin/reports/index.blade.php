@extends('layouts.dashboard')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-bar-chart-fill"></i> Laporan Penjualan</h2>
    </div>

    <!-- Filter & Export -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                    <div class="btn-group">
                        <a href="{{ route('admin.reports.export.excel', request()->all()) }}" class="btn btn-success">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                        <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1"><i class="bi bi-cart-fill"></i> Total Pesanan</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalOrders }}</h2>
                        </div>
                        <i class="bi bi-receipt" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1"><i class="bi bi-check-circle-fill"></i> Pesanan Selesai</h6>
                            <h2 class="mb-0 fw-bold">{{ $completedOrders }}</h2>
                        </div>
                        <i class="bi bi-clipboard-check" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1"><i class="bi bi-clock-history"></i> Pesanan Pending</h6>
                            <h2 class="mb-0 fw-bold">{{ $pendingOrders }}</h2>
                        </div>
                        <i class="bi bi-hourglass-split" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1"><i class="bi bi-cash-stack"></i> Total Pendapatan</h6>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                        </div>
                        <i class="bi bi-wallet2" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Detail -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detail Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($summaries as $summary)
                            <tr>
                                <td>{{ $loop->iteration + ($summaries->currentPage() - 1) * $summaries->perPage() }}</td>
                                <td>
                                    <i class="bi bi-calendar-event"></i> {{ $summary->created_at->format('d/m/Y') }}<br>
                                    <small class="text-muted"><i class="bi bi-clock"></i> {{ $summary->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <i class="bi bi-person-fill text-primary"></i> <strong>{{ $summary->order->customer->name }}</strong><br>
                                    <i class="bi bi-table text-muted"></i> <small class="text-muted">Meja: {{ $summary->order->customer->table_number ?? '-' }}</small>
                                </td>
                                <td>
                                    <i class="bi bi-cup-hot-fill text-warning"></i> {{ $summary->order->product->name }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $summary->order->quantity }}x</span>
                                </td>
                                <td>
                                    <strong class="text-success"><i class="bi bi-cash-coin"></i> Rp {{ number_format($summary->subtotal, 0, ',', '.') }}</strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-graph-down fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data transaksi.</p>
                                    <small class="text-muted">Gunakan filter tanggal untuk melihat laporan</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($summaries->isNotEmpty())
                        <tfoot>
                            <tr class="table-active">
                                <th colspan="5" class="text-end"><i class="bi bi-calculator"></i> Total:</th>
                                <th><strong class="text-success"><i class="bi bi-cash-stack"></i> Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
            
            <div class="mt-3">
                {{ $summaries->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
