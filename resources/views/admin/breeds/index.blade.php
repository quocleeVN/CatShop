@extends('layouts.admin')
@section('title', 'Quản lý giống mèo')

@section('content')
<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Danh sách giống mèo</h1>
        <a href="{{ route('admin.breeds.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600">
            + Thêm giống
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Tên giống</th>
                    <th class="px-6 py-3 text-left">Xuất xứ</th>
                    <th class="px-6 py-3 text-left">Mô tả</th>
                    <th class="px-6 py-3 text-left">Số mèo</th>
                    <th class="px-6 py-3 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($breeds as $breed)
                <tr class="border-b">
                    <td class="px-6 py-4 font-medium">{{ $breed->breed_name }}</td>
                    <td class="px-6 py-4">{{ $breed->origin }}</td>
                    <td class="px-6 py-4">{{ Str::limit($breed->description, 50) }}</td>
                    <td class="px-6 py-4">{{ $breed->cats_count }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.breeds.edit', $breed) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">Sửa</a>
                        <form action="{{ route('admin.breeds.destroy', $breed) }}" method="POST" class="inline" onsubmit="return confirm('Xóa giống này?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">{{ $breeds->links() }}</div>
    </div>
</div>
@endsection