@extends('layouts.app')
@section('title', 'Sửa địa chỉ')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <a href="{{ route('addresses.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-6">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Quay lại
        </a>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h1 class="text-2xl font-bold mb-6">Sửa địa chỉ</h1>

            <form action="{{ route('addresses.update', $address) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-1">Họ tên người nhận</label>
                        <input type="text" name="recipient_name" id="recipient_name" value="{{ old('recipient_name', $address->recipient_name) }}" class="w-full rounded-xl border-gray-300" required>
                    </div>
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $address->phone_number) }}" class="w-full rounded-xl border-gray-300" required>
                    </div>
                    <div>
                        <label for="specific_address" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ cụ thể</label>
                        <input type="text" name="specific_address" id="specific_address" value="{{ old('specific_address', $address->specific_address) }}" class="w-full rounded-xl border-gray-300" required>
                    </div>
                    <div>
                        <label for="ward" class="block text-sm font-medium text-gray-700 mb-1">Phường/Xã</label>
                        <input type="text" name="ward" id="ward" value="{{ old('ward', $address->ward) }}" class="w-full rounded-xl border-gray-300">
                    </div>
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-1">Quận/Huyện</label>
                        <input type="text" name="district" id="district" value="{{ old('district', $address->district) }}" class="w-full rounded-xl border-gray-300">
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Tỉnh/Thành phố</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $address->city) }}" class="w-full rounded-xl border-gray-300" required>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }} class="rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                        <label for="is_default" class="ml-2 text-sm text-gray-700">Đặt làm địa chỉ mặc định</label>
                    </div>
                    <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl font-semibold hover:bg-orange-600 transition">
                        Cập nhật địa chỉ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection