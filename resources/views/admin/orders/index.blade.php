@extends('layouts.dashboard')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="bi bi-cart-check-fill"></i> Kelola Pesanan</h2>
        </div>
        <div>
            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Buat Pesanan Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                <td>
                                    <i class="bi bi-person-fill text-primary"></i> <strong>{{ $order->customer->name }}</strong><br>
                                    <i class="bi bi-table text-muted"></i> <small class="text-muted">Meja: {{ $order->customer->table_number ?? '-' }}</small>
                                </td>
                                <td>
                                    <i class="bi bi-cup-hot-fill text-warning"></i> {{ $order->product->name }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $order->quantity }}x</span>
                                </td>
                                <td>
                                    <strong class="text-success">
                                        <i class="bi bi-cash-coin"></i> Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>
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
                                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm mt-1" 
                                                onchange="this.form.submit()"
                                                style="width: auto;">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processed" {{ $order->status === 'processed' ? 'selected' : '' }}>Diproses</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    @if($order->payment)
                                        @if($order->payment->status === 'success')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill"></i> Lunas
                                            </span>
                                        @elseif($order->payment->status === 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock-history"></i> Belum Lunas
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle-fill"></i> Gagal
                                            </span>
                                        @endif
                                        <br>
                                        <small class="text-muted">
                                            @if($order->payment->payment_method === 'cash')
                                                Tunai
                                            @elseif($order->payment->payment_method === 'later')
                                                Bayar Nanti
                                            @else
                                                {{ ucfirst($order->payment->payment_method) }}
                                            @endif
                                        </small>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-calendar-event"></i> {{ $order->created_at->format('d/m/Y') }}<br>
                                    <small class="text-muted"><i class="bi bi-clock"></i> {{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($order->payment && $order->payment->payment_method === 'cash' && $order->payment->status === 'pending')
                                            <a href="{{ route('admin.orders.payment-confirmation', $order) }}" class="btn btn-sm btn-warning" title="Proses Pembayaran">
                                                <i class="bi bi-cash-coin"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.orders.receipt', $order) }}" class="btn btn-sm btn-success" title="Cetak Struk">
                                            <i class="bi bi-receipt"></i>
                                        </a>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted mb-0">Belum ada data pesanan.</p>
                                    <small class="text-muted">Pesanan baru akan muncul di sini</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
