@extends('layouts.admin')
@section('title', 'Thêm giống mèo')

@section('content')
<div>
    <a href="{{ route('admin.breeds.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-4">← Quay lại</a>
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h1 class="text-2xl font-bold mb-6">Thêm giống mèo mới</h1>
        <form action="{{ route('admin.breeds.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="breed_name" class="block text-sm font-medium mb-1">Tên giống</label>
                <input type="text" name="breed_name" id="breed_name" value="{{ old('breed_name') }}" class="w-full rounded-xl border-gray-300" required>
            </div>
            <div class="mb-4">
                <label for="origin" class="block text-sm font-medium mb-1">Xuất xứ</label>
                <input type="text" name="origin" id="origin" value="{{ old('origin') }}" class="w-full rounded-xl border-gray-300">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-1">Mô tả</label>
                <textarea name="description" id="description" rows="3" class="w-full rounded-xl border-gray-300">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600">Thêm</button>
        </form>
    </div>
</div>
@endsection