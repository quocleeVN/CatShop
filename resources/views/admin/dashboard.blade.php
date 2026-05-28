@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tổng quan</h1>
        <p class="text-gray-500 text-sm">{{ now()->format('d/m/Y') }}</p>
    </div>

    <!-- Thống kê -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng số mèo</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalCats }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 text-2xl">🐱</div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $availableCats }} đang có sẵn</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Người dùng</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-500 text-2xl">👤</div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Khách hàng đã đăng ký</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Đơn hàng</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-500 text-2xl">📦</div>
            </div>
            <p class="text-xs text-gray-400 mt-2">{{ $pendingOrders }} đang chờ xử lý</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Doanh thu</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($totalRevenue, 0, ',', '.') }}đ</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-500 text-2xl">💰</div>
            </div>
            <p class="text-xs text-gray-400 mt-2">Từ đơn hàng đã giao</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Đơn hàng gần đây -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm">
            <h2 class="text-xl font-bold mb-4">Đơn hàng gần đây</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3">ID</th>
                            <th class="pb-3">Khách hàng</th>
                            <th class="pb-3">Tổng tiền</th>
                            <th class="pb-3">Trạng thái</th>
                            <th class="pb-3">Ngày</th>
                            <th class="pb-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">#{{ $order->order_id }}</td>
                            <td>{{ $order->user->full_name }}</td>
                            <td class="font-medium">{{ number_format($order->final_amount, 0, ',', '.') }}đ</td>
                            <td>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($order->order_status == 'delivered') bg-green-100 text-green-700
                                    @elseif($order->order_status == 'cancelled') bg-red-100 text-red-700
                                    @elseif($order->order_status == 'shipped') bg-blue-100 text-blue-700
                                    @else bg-yellow-100 text-yellow-700
                                    @endif">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-500 hover:underline">Xem</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Đơn hàng theo trạng thái -->
        <div class="bg-white p-6 rounded-2xl shadow-sm">
            <h2 class="text-xl font-bold mb-4">Đơn hàng theo trạng thái</h2>
            <div class="space-y-3">
                @php
                    $statuses = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'shipped' => 'Đang giao', 'delivered' => 'Đã giao', 'cancelled' => 'Đã hủy'];
                @endphp
                @foreach($statuses as $key => $label)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">{{ $label }}</span>
                        <span class="font-bold">{{ $ordersByStatus[$key] ?? 0 }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full 
                            @if($key == 'pending') bg-yellow-500
                            @elseif($key == 'processing') bg-blue-500
                            @elseif($key == 'shipped') bg-indigo-500
                            @elseif($key == 'delivered') bg-green-500
                            @else bg-red-500
                            @endif"
                            style="width: {{ $totalOrders ? ($ordersByStatus[$key] ?? 0) / $totalOrders * 100 : 0 }}%">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection