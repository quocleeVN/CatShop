@extends('layouts.admin')
@section('title', 'Thêm người dùng')

@section('content')
<div>
    <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-orange-500 inline-flex items-center mb-4">← Quay lại</a>
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h1 class="text-2xl font-bold mb-6">Thêm người dùng mới</h1>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="full_name" class="block text-sm font-medium mb-1">Họ tên</label>
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="phone_number" class="block text-sm font-medium mb-1">Số điện thoại</label>
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="w-full rounded-xl border-gray-300">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-xl border-gray-300" required>
                </div>
                <div>
                    <label for="role" class="block text-sm font-medium mb-1">Vai trò</label>
                    <select name="role" id="role" class="w-full rounded-xl border-gray-300" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
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