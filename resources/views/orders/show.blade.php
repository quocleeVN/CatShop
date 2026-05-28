@extends('layouts.app')
@section('title', 'Chi tiết đơn hàng #'.$order->order_id)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-6">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Quay lại danh sách
        </a>

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex flex-wrap justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold">Đơn hàng #{{ $order->order_id }}</h1>
                    <p class="text-gray-500 text-sm">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold mb-2">Địa chỉ giao hàng</h3>
                    <p class="text-gray-700">{{ $order->shipping_address }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Phương thức thanh toán</h3>
                    <p class="text-gray-700">{{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' }}</p>
                    <p class="text-gray-500 text-sm">Trạng thái: {{ $order->payment_status }}</p>
                </div>
            </div>

            @if($order->order_notes)
                <div class="mt-4">
                    <h3 class="font-semibold mb-2">Ghi chú</h3>
                    <p class="text-gray-700">{{ $order->order_notes }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="font-bold text-xl mb-4">Sản phẩm đã đặt</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item->cat->link_image ?? asset('images/placeholder-cat.jpg') }}" 
                                 alt="{{ $item->cat->name }}" 
                                 class="w-16 h-16 object-cover rounded-xl">
                            <div>
                                <h3 class="font-semibold">{{ $item->cat->name }}</h3>
                                <p class="text-gray-500 text-sm">{{ $item->cat->breed->breed_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold">{{ number_format($item->price_at_purchase, 0, ',', '.') }}đ</p>
                            <p class="text-gray-500 text-sm">x{{ $item->quantity }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 border-t pt-4 space-y-2">
                <div class="flex justify-between">
                    <span>Tạm tính</span>
                    <span>{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
                </div>
                <div class="flex justify-between">
                    <span>Phí vận chuyển</span>
                    <span>{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</span>
                </div>
                @if($order->coupon)
                    <div class="flex justify-between text-green-600">
                        <span>Giảm giá ({{ $order->coupon->code }})</span>
                        <span>-{{ number_format($order->total_amount + $order->shipping_fee - $order->final_amount, 0, ',', '.') }}đ</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-lg border-t pt-2">
                    <span>Tổng cộng</span>
                    <span class="text-orange-500">{{ number_format($order->final_amount, 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection