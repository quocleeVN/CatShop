@extends('layouts.app')
@section('title', 'Thanh toán')

@section('content')
<div class="container mx-auto px-4 py-8">
    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-xl font-bold mb-4">Địa chỉ giao hàng</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Họ tên người nhận</label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->full_name) }}" class="w-full rounded-xl border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Số điện thoại</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" class="w-full rounded-xl border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Địa chỉ cụ thể</label>
                            <textarea name="shipping_address" rows="3" class="w-full rounded-xl border-gray-300" required>{{ old('shipping_address', optional(auth()->user()->defaultAddress())->full_address) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-xl font-bold mb-4">Phương thức thanh toán</h2>
                    <div class="space-y-3">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="cod" checked class="text-orange-500">
                            <span class="ml-2">Thanh toán khi nhận hàng (COD)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="bank_transfer" class="text-orange-500">
                            <span class="ml-2">Chuyển khoản ngân hàng</span>
                        </label>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-xl font-bold mb-4">Ghi chú</h2>
                    <textarea name="order_notes" rows="2" class="w-full rounded-xl border-gray-300" placeholder="Ghi chú cho đơn hàng...">{{ old('order_notes') }}</textarea>
                </div>
            </div>
            <div>
                <div class="bg-white p-6 rounded-2xl shadow-sm sticky top-24">
                    <h3 class="text-lg font-bold mb-4">Tóm tắt đơn hàng</h3>
                    <div class="space-y-2 text-sm">
                        @foreach($cartItems as $item)
                            @php $cat = $item['cat']; @endphp
                            <div class="flex justify-between">
                                <span>{{ $cat->name }} x {{ $item['quantity'] }}</span>
                                <span>{{ number_format($cat->price * $item['quantity']) }}đ</span>
                            </div>
                        @endforeach
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between">
                        <span>Tạm tính</span>
                        <span>{{ number_format($subtotal) }}đ</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Phí vận chuyển</span>
                        <span>{{ number_format($shippingFee) }}đ</span>
                    </div>
                    @if($discount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Giảm giá</span>
                            <span>-{{ number_format($discount) }}đ</span>
                        </div>
                    @endif
                    <div class="mt-4">
                        <form action="{{ route('checkout.applyCoupon') }}" method="POST" class="flex space-x-2">
                            @csrf
                            <input type="text" name="code" value="{{ $couponCode }}" class="flex-1 rounded-xl border-gray-300" placeholder="Mã giảm giá">
                            <button class="bg-gray-200 px-4 py-2 rounded-xl hover:bg-gray-300">Áp dụng</button>
                        </form>
                        @if($couponCode)
                            <p class="text-sm text-green-600 mt-1">Đã áp dụng mã {{ $couponCode }}</p>
                        @endif
                    </div>
                    <div class="flex justify-between font-bold text-lg mt-3">
                        <span>Tổng cộng</span>
                        <span class="text-orange-500">{{ number_format($total) }}đ</span>
                    </div>
                    <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl mt-4 font-semibold hover:bg-orange-600">
                        Đặt hàng
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection