@extends('layouts.dashboard')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-cash-coin"></i> Konfirmasi Pembayaran</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <!-- Order Summary -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h5 class="mb-3"><i class="bi bi-cart-check"></i> Ringkasan Pesanan</h5>
                        <div class="bg-light p-3 rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <span><strong>Pelanggan:</strong></span>
                                <span>{{ $order->customer->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><strong>Meja:</strong></span>
                                <span class="badge bg-primary">{{ $order->customer->table_number }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><strong>No. Transaksi:</strong></span>
                                <span>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="mb-4 pb-4 border-bottom">
                        <h6 class="mb-3">Detail Pesanan:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $grandTotal = 0;
                                    @endphp
                                    @foreach($relatedOrders as $item)
                                        @php
                                            $grandTotal += $item->total_price;
                                        @endphp
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total Pembayaran:</strong></td>
                                        <td class="text-end"><strong class="text-primary fs-5">Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    @if($order->payment->payment_method === 'cash')
                        <form action="{{ route('admin.orders.process-payment', $order->id) }}" method="POST" id="paymentForm">
                            @csrf
                            <div class="mb-4">
                                <h5 class="mb-3"><i class="bi bi-wallet2"></i> Input Pembayaran Cash</h5>
                                
                                <div class="mb-3">
                                    <label for="total_amount" class="form-label">Total yang Harus Dibayar</label>
                                    <input type="text" class="form-control form-control-lg bg-light" id="total_amount" 
                                        value="Rp {{ number_format($grandTotal, 0, ',', '.') }}" readonly>
                                    <input type="hidden" name="total_amount" value="{{ $grandTotal }}">
                                </div>

                                <div class="mb-3">
                                    <label for="cash_paid" class="form-label">Uang yang Dibayarkan <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="cash_paid" name="cash_paid" 
                                               min="{{ $grandTotal }}" step="1000" required autofocus
                                               placeholder="Masukkan jumlah uang">
                                    </div>
                                    <small class="text-muted">Minimal: Rp {{ number_format($grandTotal, 0, ',', '.') }}</small>
                                </div>

                                <!-- Quick Amount Buttons -->
                                <div class="mb-3">
                                    <label class="form-label">Nominal Cepat:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-outline-primary quick-amount" data-amount="{{ $grandTotal }}">Uang Pas</button>
                                        @php
                                            $suggestions = [];
                                            $roundedTotal = ceil($grandTotal / 1000) * 1000;
                                            
                                            // Suggest rounded amounts
                                            if ($roundedTotal > $grandTotal) {
                                                $suggestions[] = $roundedTotal;
                                            }
                                            
                                            // Common denominations
                                            $denominations = [20000, 50000, 100000, 200000, 500000];
                                            foreach ($denominations as $denom) {
                                                if ($denom >= $grandTotal && !in_array($denom, $suggestions)) {
                                                    $suggestions[] = $denom;
                                                }
                                            }
                                            
                                            // Limit to 5 suggestions
                                            $suggestions = array_slice($suggestions, 0, 5);
                                        @endphp
                                        @foreach($suggestions as $amount)
                                            <button type="button" class="btn btn-outline-primary quick-amount" data-amount="{{ $amount }}">
                                                Rp {{ number_format($amount, 0, ',', '.') }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Change Display -->
                                <div class="alert alert-info" id="changeDisplay" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><strong>Kembalian:</strong></span>
                                        <span class="fs-4 fw-bold" id="changeAmount">Rp 0</span>
                                    </div>
                                </div>

                                <div class="alert alert-warning" id="insufficientWarning" style="display: none;">
                                    <i class="bi bi-exclamation-triangle"></i> Uang yang dibayarkan kurang dari total!
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success btn-lg flex-fill" id="submitBtn" disabled>
                                    <i class="bi bi-check-circle"></i> Proses & Cetak Struk
                                </button>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    @else
                        <!-- For non-cash payment -->
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Pembayaran dengan metode: <strong>{{ strtoupper($order->payment->payment_method) }}</strong>
                        </div>
                        <a href="{{ route('admin.orders.receipt', $order->id) }}" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-printer"></i> Cetak Struk
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cashPaidInput = document.getElementById('cash_paid');
    const totalAmount = {{ $grandTotal }};
    const changeDisplay = document.getElementById('changeDisplay');
    const changeAmountSpan = document.getElementById('changeAmount');
    const insufficientWarning = document.getElementById('insufficientWarning');
    const submitBtn = document.getElementById('submitBtn');
    const quickAmountBtns = document.querySelectorAll('.quick-amount');

    // Quick amount buttons
    quickAmountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = this.getAttribute('data-amount');
            cashPaidInput.value = amount;
            calculateChange();
        });
    });

    // Calculate change on input
    if (cashPaidInput) {
        cashPaidInput.addEventListener('input', calculateChange);
    }

    function calculateChange() {
        const cashPaid = parseFloat(cashPaidInput.value) || 0;
        const change = cashPaid - totalAmount;

        if (cashPaid >= totalAmount) {
            changeDisplay.style.display = 'block';
            insufficientWarning.style.display = 'none';
            changeAmountSpan.textContent = 'Rp ' + change.toLocaleString('id-ID');
            submitBtn.disabled = false;
        } else if (cashPaid > 0) {
            changeDisplay.style.display = 'none';
            insufficientWarning.style.display = 'block';
            submitBtn.disabled = true;
        } else {
            changeDisplay.style.display = 'none';
            insufficientWarning.style.display = 'none';
            submitBtn.disabled = true;
        }
    }
});
</script>
@endpush
@endsection
