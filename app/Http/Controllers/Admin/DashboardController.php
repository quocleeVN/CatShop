<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCats = Cat::count();
        $availableCats = Cat::where('stock_status', 'available')->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalRevenue = Order::where('order_status', 'delivered')->sum('final_amount');
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Đơn hàng theo trạng thái
        $ordersByStatus = Order::selectRaw('order_status, COUNT(*) as count')
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        return view('admin.dashboard', compact(
            'totalCats',
            'availableCats',
            'totalOrders',
            'pendingOrders',
            'totalUsers',
            'totalRevenue',
            'recentOrders',
            'ordersByStatus'
        ));
    }
}
