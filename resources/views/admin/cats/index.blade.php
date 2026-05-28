@extends('layouts.admin')
@section('title', 'Quản lý mèo')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Danh sách mèo</h1>
        <a href="{{ route('admin.cats.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition">
            + Thêm mèo
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left">Ảnh</th>
                        <th class="px-6 py-3 text-left">Tên</th>
                        <th class="px-6 py-3 text-left">Giống</th>
                        <th class="px-6 py-3 text-left">Giá</th>
                        <th class="px-6 py-3 text-left">Tuổi</th>
                        <th class="px-6 py-3 text-left">Giới tính</th>
                        <th class="px-6 py-3 text-left">Trạng thái</th>
                        <th class="px-6 py-3 text-left">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cats as $cat)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <img src="{{ $cat->link_image ?? asset('images/placeholder-cat.jpg') }}" 
                                 alt="{{ $cat->name }}" 
                                 class="w-12 h-12 object-cover rounded-lg">
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $cat->name }}</td>
                        <td class="px-6 py-4">{{ $cat->breed->breed_name }}</td>
                        <td class="px-6 py-4">{{ number_format($cat->price, 0, ',', '.') }}đ</td>
                        <td class="px-6 py-4">{{ $cat->age_in_months }} tháng</td>
                        <td class="px-6 py-4">{{ $cat->gender == 'male' ? 'Đực' : 'Cái' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if($cat->stock_status == 'available') bg-green-100 text-green-700
                                @elseif($cat->stock_status == 'sold') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ $cat->stock_status == 'available' ? 'Còn hàng' : ($cat->stock_status == 'sold' ? 'Đã bán' : 'Đã đặt') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.cats.show', $cat) }}" class="text-blue-500 hover:text-blue-700">Xem</a>
                                <a href="{{ route('admin.cats.edit', $cat) }}" class="text-yellow-500 hover:text-yellow-700">Sửa</a>
                                <form action="{{ route('admin.cats.destroy', $cat) }}" method="POST" onsubmit="return confirm('Xóa mèo này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">Không có mèo nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $cats->links() }}
        </div>
    </div>
</div>
@endsection