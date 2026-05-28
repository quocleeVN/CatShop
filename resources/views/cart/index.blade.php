@extends('layouts.app')
@section('title', 'Giỏ hàng')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Giỏ hàng của bạn</h1>

    @if(count($cartItems) > 0)
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="space-y-4">
                @foreach($cartItems as $item)
                    @php $cat = $item['cat']; $qty = $item['quantity']; @endphp
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $cat->link_image ?? asset('images/placeholder-cat.jpg') }}" alt="{{ $cat->name }}" class="w-20 h-20 object-cover rounded-xl">
                            <div>
                                <h3 class="font-semibold">{{ $cat->name }}</h3>
                                <p class="text-gray-500">{{ $cat->breed->breed_name }}</p>
                                <p class="text-orange-500 font-bold">{{ number_format($cat->price, 0, ',', '.') }}đ</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('cart.update', $cat->cat_id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $qty }}" min="1" class="w-16 rounded-xl border-gray-300 text-center">
                                <button type="submit" class="ml-2 text-blue-500 hover:underline">Cập nhật</button>
                            </form>
                            <form action="{{ route('cart.remove', $cat->cat_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 flex justify-between items-center">
                <div>
                    <p class="text-lg font-bold">Tổng cộng: <span class="text-orange-500">{{ number_format($total, 0, ',', '.') }}đ</span></p>
                </div>
                <a href="{{ route('checkout.index') }}" class="bg-orange-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-orange-600">Thanh toán</a>
            </div>
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 mb-4">Giỏ hàng trống trơn 😿</p>
            <a href="{{ route('cats.index') }}" class="text-orange-500 underline">Tiếp tục mua sắm</a>
        </div>
    @endif
</div>
@endsection