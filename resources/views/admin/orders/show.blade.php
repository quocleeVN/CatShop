@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng #'.$order->order_id)

@section('content')
<div>
    <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-4">← Quay lại</a>

    <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold">Đơn hàng #{{ $order->order_id }}</h1>
                <p class="text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="mt-2">Khách hàng: <span class="font-medium">{{ $order->user->full_name }}</span> ({{ $order->user->email }})</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                @if($order->order_status == 'delivered') bg-green-100 text-green-700
                @elseif($order->order_status == 'cancelled') bg-red-100 text-red-700
                @elseif($order->order_status == 'shipped') bg-blue-100 text-blue-700
                @else bg-yellow-100 text-yellow-700
                @endif">
                {{ ucfirst($order->order_status) }}
            </span>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold">Địa chỉ giao hàng</h3>
                <p class="text-gray-700">{{ $order->shipping_address }}</p>
            </div>
            <div>
                <h3 class="font-semibold">Phương thức thanh toán</h3>
                <p>{{ $order->payment_method == 'cod' ? 'COD' : 'Chuyển khoản' }}</p>
                <p>Trạng thái: {{ $order->payment_status }}</p>
            </div>
        </div>

        @if($order->order_notes)
            <div class="mt-4">
                <h3 class="font-semibold">Ghi chú</h3>
                <p>{{ $order->order_notes }}</p>
            </div>
        @endif

        <!-- Cập nhật trạng thái -->
        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold mb-2">Cập nhật trạng thái</h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="order_status" class="rounded-xl border-gray-300">
                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                </select>
                <select name="payment_status" class="rounded-xl border-gray-300">
                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Chưa thanh toán</option>
                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Thất bại</option>
                    <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                </select>
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-xl">Cập nhật</button>
            </form>
        </div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="font-bold text-xl mb-4">Sản phẩm</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b"><th class="text-left pb-2">Mèo</th><th class="text-right pb-2">Đơn giá</th><th class="text-right pb-2">SL</th><th class="text-right pb-2">Tổng</th></tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-b">
                    <td class="py-3">{{ $item->cat->name }} ({{ $item->cat->breed->breed_name }})</td>
                    <td class="text-right">{{ number_format($item->price_at_purchase) }}đ</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right font-medium">{{ number_format($item->price_at_purchase * $item->quantity) }}đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 text-right space-y-1">
            <p>Tạm tính: {{ number_format($order->total_amount) }}đ</p>
            <p>Phí ship: {{ number_format($order->shipping_fee) }}đ</p>
            <p class="font-bold text-lg">Tổng cộng: <span class="text-orange-500">{{ number_format($order->final_amount) }}đ</span></p>
        </div>
    </div>
</div>
@endsection