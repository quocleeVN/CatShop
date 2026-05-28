@extends('layouts.admin')
@section('title', 'Quản lý mã giảm giá')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Danh sách mã giảm giá</h1>
        <a href="{{ route('admin.coupons.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600">+ Thêm mã</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Mã</th>
                    <th class="px-6 py-3 text-left">% Giảm</th>
                    <th class="px-6 py-3 text-left">Giảm tối đa</th>
                    <th class="px-6 py-3 text-left">Đơn tối thiểu</th>
                    <th class="px-6 py-3 text-left">Hạn</th>
                    <th class="px-6 py-3 text-left">Trạng thái</th>
                    <th class="px-6 py-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coupons as $coupon)
                <tr class="border-b">
                    <td class="px-6 py-4 font-mono font-bold">{{ $coupon->code }}</td>
                    <td class="px-6 py-4">{{ $coupon->discount_percent }}%</td>
                    <td class="px-6 py-4">{{ $coupon->max_discount ? number_format($coupon->max_discount).'đ' : '-' }}</td>
                    <td class="px-6 py-4">{{ number_format($coupon->min_order_value) }}đ</td>
                    <td class="px-6 py-4">{{ $coupon->expiry_date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs {{ $coupon->is_active && $coupon->expiry_date >= now() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $coupon->is_active && $coupon->expiry_date >= now() ? 'Hiệu lực' : 'Hết hạn' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-yellow-500 mr-2">Sửa</a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline" onsubmit="return confirm('Xóa mã này?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $coupons->links() }}</div>
    </div>
</div>
@endsection