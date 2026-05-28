@extends('layouts.app')
@section('title', 'Liên hệ')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl">
    <h1 class="text-4xl font-bold text-center mb-8">Liên hệ với CatShop</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4">Thông tin liên hệ</h2>
            <ul class="space-y-3">
                <li class="flex items-center"><span class="text-orange-500 mr-2">📞</span> 0901 234 567</li>
                <li class="flex items-center"><span class="text-orange-500 mr-2">📧</span> info@catshop.com</li>
                <li class="flex items-center"><span class="text-orange-500 mr-2">📍</span> 123 Đường ABC, Quận 1, TP. Hồ Chí Minh</li>
            </ul>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4">Gửi tin nhắn</h2>
            <form class="space-y-4">
                <input type="text" placeholder="Họ tên" class="w-full rounded-xl border-gray-300">
                <input type="email" placeholder="Email" class="w-full rounded-xl border-gray-300">
                <textarea rows="4" placeholder="Nội dung..." class="w-full rounded-xl border-gray-300"></textarea>
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-xl font-semibold hover:bg-orange-600">Gửi</button>
            </form>
        </div>
    </div>
</div>
@endsection