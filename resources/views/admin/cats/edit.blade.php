@extends('layouts.admin')
@section('title', 'Sửa mèo')

@section('content')
<div>
    <a href="{{ route('admin.cats.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-4">
        ← Quay lại
    </a>

    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h1 class="text-2xl font-bold mb-6">Sửa mèo: {{ $cat->name }}</h1>

        <form action="{{ route('admin.cats.update', $cat) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium mb-1">Tên mèo</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $cat->name) }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="breed_id" class="block text-sm font-medium mb-1">Giống mèo</label>
                    <select name="breed_id" id="breed_id" class="w-full rounded-xl border-gray-300" required>
                        <option value="">Chọn giống</option>
                        @foreach($breeds as $breed)
                            <option value="{{ $breed->breed_id }}" {{ old('breed_id', $cat->breed_id) == $breed->breed_id ? 'selected' : '' }}>
                                {{ $breed->breed_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="price" class="block text-sm font-medium mb-1">Giá (VNĐ)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $cat->price) }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="age_in_months" class="block text-sm font-medium mb-1">Tuổi (tháng)</label>
                    <input type="number" name="age_in_months" id="age_in_months" value="{{ old('age_in_months', $cat->age_in_months) }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium mb-1">Giới tính</label>
                    <select name="gender" id="gender" class="w-full rounded-xl border-gray-300" required>
                        <option value="male" {{ old('gender', $cat->gender) == 'male' ? 'selected' : '' }}>Đực</option>
                        <option value="female" {{ old('gender', $cat->gender) == 'female' ? 'selected' : '' }}>Cái</option>
                    </select>
                </div>
                <div>
                    <label for="color" class="block text-sm font-medium mb-1">Màu sắc</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $cat->color) }}" class="w-full rounded-xl border-gray-300">
                </div>
                <div>
                    <label for="weight" class="block text-sm font-medium mb-1">Cân nặng (kg)</label>
                    <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight', $cat->weight) }}" class="w-full rounded-xl border-gray-300">
                </div>
                <div>
                    <label for="health_status" class="block text-sm font-medium mb-1">Tình trạng sức khỏe</label>
                    <input type="text" name="health_status" id="health_status" value="{{ old('health_status', $cat->health_status) }}" class="w-full rounded-xl border-gray-300">
                </div>
                <div>
                    <label for="stock_status" class="block text-sm font-medium mb-1">Trạng thái tồn kho</label>
                    <select name="stock_status" id="stock_status" class="w-full rounded-xl border-gray-300" required>
                        <option value="available" {{ old('stock_status', $cat->stock_status) == 'available' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="sold" {{ old('stock_status', $cat->stock_status) == 'sold' ? 'selected' : '' }}>Đã bán</option>
                        <option value="reserved" {{ old('stock_status', $cat->stock_status) == 'reserved' ? 'selected' : '' }}>Đã đặt</option>
                    </select>
                </div>
                <div>
                    <label for="link_image" class="block text-sm font-medium mb-1">Link ảnh</label>
                    <input type="url" name="link_image" id="link_image" value="{{ old('link_image', $cat->link_image) }}" class="w-full rounded-xl border-gray-300">
                </div>
                <div class="flex items-center mt-8">
                    <input type="checkbox" name="is_vaccinated" id="is_vaccinated" value="1" {{ old('is_vaccinated', $cat->is_vaccinated) ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500">
                    <label for="is_vaccinated" class="ml-2 text-sm">Đã tiêm phòng</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium mb-1">Mô tả</label>
                <textarea name="description" id="description" rows="3" class="w-full rounded-xl border-gray-300">{{ old('description', $cat->description) }}</textarea>
            </div>

            <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition">Cập nhật</button>
        </form>
    </div>
</div>
@endsection