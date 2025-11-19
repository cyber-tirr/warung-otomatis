<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 5px 0;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>WARUNG KOPI OTOMATIS</h2>
        <h3>Laporan Penjualan</h3>
        @if($startDate || $endDate)
            <p>
                Periode: 
                {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Awal' }} 
                - 
                {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Sekarang' }}
            </p>
        @endif
    </div>

    <div class="info">
        <p><strong>Dicetak pada:</strong> {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summaries as $index => $summary)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $summary->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $summary->order->customer->name }}<br>
                        <small>Meja: {{ $summary->order->customer->table_number ?? '-' }}</small>
                    </td>
                    <td>{{ $summary->order->product->name }}</td>
                    <td>{{ $summary->order->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($summary->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>TOTAL PENDAPATAN:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem.</p>
    </div>
</body>
</html>
