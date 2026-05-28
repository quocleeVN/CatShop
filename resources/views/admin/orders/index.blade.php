@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')

@section('content')
<div>
    <h1 class="text-2xl font-bold mb-6">Danh sách đơn hàng</h1>

    <div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Khách hàng</th>
                    <th class="px-6 py-3 text-left">Tổng tiền</th>
                    <th class="px-6 py-3 text-left">Thanh toán</th>
                    <th class="px-6 py-3 text-left">Trạng thái</th>
                    <th class="px-6 py-3 text-left">Ngày</th>
                    <th class="px-6 py-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b">
                    <td class="px-6 py-4">#{{ $order->order_id }}</td>
                    <td class="px-6 py-4">{{ $order->user->full_name }}</td>
                    <td class="px-6 py-4">{{ number_format($order->final_amount) }}đ</td>
                    <td class="px-6 py-4">{{ $order->payment_method == 'cod' ? 'COD' : 'CK' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($order->order_status == 'delivered') bg-green-100 text-green-700
                            @elseif($order->order_status == 'cancelled') bg-red-100 text-red-700
                            @elseif($order->order_status == 'shipped') bg-blue-100 text-blue-700
                            @else bg-yellow-100 text-yellow-700
                            @endif">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-500 hover:underline">Xem</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $orders->links() }}</div>
    </div>
</div>
@endsection