@extends('layouts.guest')
@section('title', 'Đăng nhập')

@section('content')
<h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Đăng nhập vào CatShop</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-xl border-gray-300">
    </div>
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium mb-1">Mật khẩu</label>
        <input id="password" type="password" name="password" required class="w-full rounded-xl border-gray-300">
    </div>
    <div class="flex items-center justify-between mb-4">
        <label class="flex items-center text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-orange-500"> <span class="ml-2">Nhớ tài khoản</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-sm text-orange-500 hover:underline">Quên mật khẩu?</a>
    </div>
    <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-xl font-semibold hover:bg-orange-600">Đăng nhập</button>
</form>
<p class="mt-4 text-center text-sm text-gray-600">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:underline">Đăng ký</a></p>
@endsection