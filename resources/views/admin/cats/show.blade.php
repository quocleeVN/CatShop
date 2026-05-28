@extends('layouts.admin')
@section('title', 'Chi tiết mèo: ' . $cat->name)

@section('content')
<div>
    <a href="{{ route('admin.cats.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-4">
        ← Quay lại
    </a>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="md:w-1/3">
                <img src="{{ $cat->link_image ?? asset('images/placeholder-cat.jpg') }}" alt="{{ $cat->name }}" class="w-full rounded-2xl object-cover">
            </div>
            <div class="md:w-2/3">
                <h1 class="text-3xl font-bold text-gray-800">{{ $cat->name }}</h1>
                <p class="text-lg text-orange-500 font-bold mt-2">{{ number_format($cat->price, 0, ',', '.') }}đ</p>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div><span class="text-gray-500">Giống:</span> <span class="font-medium">{{ $cat->breed->breed_name }}</span></div>
                    <div><span class="text-gray-500">Tuổi:</span> <span class="font-medium">{{ $cat->age_in_months }} tháng</span></div>
                    <div><span class="text-gray-500">Giới tính:</span> <span class="font-medium">{{ $cat->gender == 'male' ? 'Đực' : 'Cái' }}</span></div>
                    <div><span class="text-gray-500">Màu sắc:</span> <span class="font-medium">{{ $cat->color ?? 'N/A' }}</span></div>
                    <div><span class="text-gray-500">Cân nặng:</span> <span class="font-medium">{{ $cat->weight }} kg</span></div>
                    <div><span class="text-gray-500">Sức khỏe:</span> <span class="font-medium">{{ $cat->health_status }}</span></div>
                    <div><span class="text-gray-500">Tiêm phòng:</span> <span class="font-medium">{{ $cat->is_vaccinated ? 'Rồi' : 'Chưa' }}</span></div>
                    <div><span class="text-gray-500">Trạng thái:</span> 
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($cat->stock_status == 'available') bg-green-100 text-green-700
                            @elseif($cat->stock_status == 'sold') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700
                            @endif">
                            {{ $cat->stock_status == 'available' ? 'Còn hàng' : ($cat->stock_status == 'sold' ? 'Đã bán' : 'Đã đặt') }}
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="font-semibold">Mô tả</h3>
                    <p class="text-gray-700 mt-1">{{ $cat->description ?? 'Chưa có mô tả.' }}</p>
                </div>

                <div class="mt-4 flex space-x-3">
                    <a href="{{ route('admin.cats.edit', $cat) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-xl hover:bg-yellow-600">Sửa</a>
                    <form action="{{ route('admin.cats.destroy', $cat) }}" method="POST" onsubmit="return confirm('Xóa mèo này?')">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection