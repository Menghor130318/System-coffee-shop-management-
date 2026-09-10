<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display sales reports (paid vs unpaid) and total revenue.
     */
    public function index(Request $request)
    {
        // Date filter (default: current month)
        $from = $request->input('from');
        $to = $request->input('to');

        $ordersQuery = Order::query();

        if ($from) {
            $ordersQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $ordersQuery->whereDate('created_at', '<=', $to);
        }

        // Summary stats
        $totalOrders = (clone $ordersQuery)->count();
        $paidOrders = (clone $ordersQuery)->where('payment_status', 'paid')->count();
        $unpaidOrders = (clone $ordersQuery)->where('payment_status', '!=', 'paid')->count();

        $totalRevenue = (clone $ordersQuery)->where('payment_status', 'paid')->sum('total');
        $totalUnpaid = (clone $ordersQuery)->where('payment_status', '!=', 'paid')->sum('total');

        // Payment method breakdown
        $byMethod = (clone $ordersQuery)
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->where('payment_status', 'paid')
            ->groupBy('payment_method')
            ->get();

        // Recent orders
        $recentOrders = (clone $ordersQuery)
            ->with(['user', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        return view('pages.report.index', compact(
            'totalOrders',
            'paidOrders',
            'unpaidOrders',
            'totalRevenue',
            'totalUnpaid',
            'byMethod',
            'recentOrders',
            'from',
            'to'
        ));
    }
}
