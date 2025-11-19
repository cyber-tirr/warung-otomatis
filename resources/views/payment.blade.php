@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-credit-card"></i> Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Silakan selesaikan pembayaran Anda untuk melanjutkan pesanan.
                    </div>

                    <h5>Detail Pesanan</h5>
                    <table class="table">
                        <tr>
                            <th width="30%">Produk</th>
                            <td>{{ $order->product->name }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $order->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Harga Satuan</th>
                            <td>Rp {{ number_format($order->product->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td><strong class="text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>

                    <hr>

                    <h5>Informasi Pelanggan</h5>
                    <table class="table">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $order->customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Meja</th>
                            <td><span class="badge bg-primary">{{ $order->customer->table_number ?? '-' }}</span></td>
                        </tr>
                    </table>

                    <div class="text-center mt-4">
                        <button type="button" id="pay-button" class="btn btn-primary btn-lg">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay('{{ $order->payment->payment_data["snap_token"] }}', {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                window.location.href = '{{ route("home") }}?payment=success';
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                window.location.href = '{{ route("home") }}?payment=pending';
            },
            onError: function(result) {
                console.log('Payment error:', result);
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                console.log('Payment popup closed');
            }
        });
    });
</script>
@endpush
@endsection
