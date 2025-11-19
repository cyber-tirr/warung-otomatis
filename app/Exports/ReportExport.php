<?php

namespace App\Exports;

use App\Models\OrderSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = OrderSummary::with('order.product', 'order.customer');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Pelanggan',
            'Nomor Meja',
            'Produk',
            'Jumlah',
            'Subtotal',
        ];
    }

    public function map($summary): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $summary->created_at->format('d/m/Y H:i'),
            $summary->order->customer->name,
            $summary->order->customer->table_number ?? '-',
            $summary->order->product->name,
            $summary->order->quantity,
            'Rp ' . number_format($summary->subtotal, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
