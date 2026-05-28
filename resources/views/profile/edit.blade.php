@extends('layouts.app')
@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Hồ sơ của bạn</h1>

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Thông tin cá nhân</h2>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                        <input type="text" name="full_name" id="full_name" 
                               value="{{ old('full_name', $user->full_name) }}" 
                               class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500" 
                               required>
                        @error('full_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" value="{{ $user->email }}" 
                               class="w-full rounded-xl border-gray-300 bg-gray-100" disabled>
                        <p class="text-sm text-gray-500 mt-1">Email không thể thay đổi.</p>
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                        <input type="text" name="phone_number" id="phone_number" 
                               value="{{ old('phone_number', $user->phone_number) }}" 
                               class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                        @error('phone_number') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <hr class="my-4">

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới (để trống nếu không đổi)</label>
                        <input type="password" name="password" id="password" 
                               class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
                            Cập nhật thông tin
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4">Địa chỉ của bạn</h2>
            @if($user->addresses->count())
                <ul class="divide-y">
                    @foreach($user->addresses as $address)
                        <li class="py-3 flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $address->recipient_name }} - {{ $address->phone_number }}</p>
                                <p class="text-gray-600 text-sm">{{ $address->full_address }}</p>
                                @if($address->is_default)
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Mặc định</span>
                                @endif
                            </div>
                            <a href="{{ route('addresses.edit', $address) }}" class="text-orange-500 hover:underline text-sm font-medium">Sửa</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Bạn chưa có địa chỉ nào.</p>
            @endif
            <div class="mt-4">
                <a href="{{ route('addresses.create') }}" class="inline-block bg-orange-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:bg-orange-600 transition">
                    Thêm địa chỉ mới
                </a>
            </div>
        </div>
    </div>
</div>
@endsection