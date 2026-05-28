@extends('layouts.admin')
@section('title', 'Thêm mã giảm giá')

@section('content')
<div>
    <a href="{{ route('admin.coupons.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-4">← Quay lại</a>
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h1 class="text-2xl font-bold mb-6">Thêm mã giảm giá</h1>
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="code" class="block text-sm font-medium mb-1">Mã</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="discount_percent" class="block text-sm font-medium mb-1">Phần trăm giảm</label>
                    <input type="number" name="discount_percent" id="discount_percent" value="{{ old('discount_percent') }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="max_discount" class="block text-sm font-medium mb-1">Giảm tối đa (để trống nếu không giới hạn)</label>
                    <input type="number" name="max_discount" id="max_discount" value="{{ old('max_discount') }}" class="w-full rounded-xl border-gray-300">
                </div>
                <div>
                    <label for="min_order_value" class="block text-sm font-medium mb-1">Đơn hàng tối thiểu</label>
                    <input type="number" name="min_order_value" id="min_order_value" value="{{ old('min_order_value', 0) }}" class="w-full rounded-xl border-gray-300">
                </div>
                <div>
                    <label for="expiry_date" class="block text-sm font-medium mb-1">Ngày hết hạn</label>
                    <input type="datetime-local" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div class="flex items-center mt-8">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500">
                    <label for="is_active" class="ml-2 text-sm">Kích hoạt</label>
                </div>
            </div>
            <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600">Thêm</button>
        </form>
    </div>
</div>
@endsection