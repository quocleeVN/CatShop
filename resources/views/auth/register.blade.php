@extends('layouts.guest')
@section('title', 'Đăng ký')

@section('content')
<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Tạo tài khoản CatShop</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="mb-4">
        <label for="full_name" class="block text-sm font-medium mb-1">Họ và tên</label>
        <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full rounded-xl border-gray-300">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border-gray-300">
    </div>
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium mb-1">Mật khẩu</label>
        <input id="password" type="password" name="password" required class="w-full rounded-xl border-gray-300">
    </div>
    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium mb-1">Xác nhận mật khẩu</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full rounded-xl border-gray-300">
    </div>
    <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl font-semibold hover:bg-orange-600">Đăng ký</button>
</form>
<p class="mt-4 text-center text-sm text-gray-600">Đã có tài khoản? <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:underline">Đăng nhập</a></p>
@endsection