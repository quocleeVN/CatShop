@extends('layouts.app')
@section('title', 'Danh sách mèo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filter sidebar -->
        <aside class="md:w-64 flex-shrink-0">
            <form method="GET" class="bg-white p-6 rounded-2xl shadow-sm sticky top-24">
                <h3 class="font-bold text-lg mb-4">Bộ lọc</h3>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Giống mèo</label>
                    <select name="breed" class="w-full rounded-xl border-gray-300">
                        <option value="">Tất cả</option>
                        @foreach($breeds as $breed)
                            <option value="{{ $breed->breed_id }}" {{ request('breed') == $breed->breed_id ? 'selected' : '' }}>
                                {{ $breed->breed_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Khoảng giá</label>
                    <div class="flex space-x-2">
                        <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}" class="w-1/2 rounded-xl border-gray-300">
                        <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}" class="w-1/2 rounded-xl border-gray-300">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Giới tính</label>
                    <select name="gender" class="w-full rounded-xl border-gray-300">
                        <option value="">Tất cả</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Đực</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Cái</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-xl hover:bg-orange-600">Lọc</button>
            </form>
        </aside>
        <!-- Product grid -->
        <div class="flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($cats as $cat)
                    <x-product-card :cat="$cat" />
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500">Không tìm thấy mèo nào phù hợp 😿</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $cats->links() }}
            </div>
        </div>
    </div>
</div>
@endsection