@extends('layouts.app')
@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Đơn hàng của bạn</h1>

    @if($orders->count())
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h3 class="font-semibold text-lg">Đơn hàng #{{ $order->order_id }}</h3>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                @if($order->order_status == 'delivered') bg-green-100 text-green-700
                                @elseif($order->order_status == 'cancelled') bg-red-100 text-red-700
                                @elseif($order->order_status == 'shipped') bg-blue-100 text-blue-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucfirst($order->order_status) }}
                            </span>
                            <span class="font-bold text-orange-500">{{ number_format($order->final_amount, 0, ',', '.') }}đ</span>
                            <a href="{{ route('orders.show', $order) }}" class="text-orange-500 hover:text-orange-700 underline text-sm font-medium">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($order->items as $item)
                            <img src="{{ $item->cat->link_image ?? asset('images/placeholder-cat.jpg') }}" 
                                 alt="{{ $item->cat->name }}" 
                                 class="w-12 h-12 object-cover rounded-lg border" 
                                 title="{{ $item->cat->name }} x{{ $item->quantity }}">
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <div class="text-6xl mb-4">📦</div>
            <p class="text-gray-500 mb-4">Bạn chưa có đơn hàng nào.</p>
            <a href="{{ route('cats.index') }}" class="text-orange-500 underline font-medium">Mua sắm ngay</a>
        </div>
    @endif
</div>
@endsection