<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderSummary::with('order.product', 'order.customer');

        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $summaries = $query->latest()->paginate(20);
        $totalRevenue = $query->sum('subtotal');

        // Statistik tambahan
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $pendingOrders = Order::where('status', 'pending')->count();

        return view('admin.reports.index', compact(
            'summaries',
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders'
        ));
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $filename = 'laporan-penjualan-' . now()->format('Y-m-d-His') . '.xlsx';

        return Excel::download(new ReportExport($startDate, $endDate), $filename);
    }

    public function exportPdf(Request $request)
    {
        $query = OrderSummary::with('order.product', 'order.customer');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $summaries = $query->latest()->get();
        $totalRevenue = $summaries->sum('subtotal');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $pdf = Pdf::loadView('admin.reports.pdf', compact('summaries', 'totalRevenue', 'startDate', 'endDate'));
        
        $filename = 'laporan-penjualan-' . now()->format('Y-m-d-His') . '.pdf';
        
        return $pdf->download($filename);
    }
}
