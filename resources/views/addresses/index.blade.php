@extends('layouts.app')
@section('title', 'Địa chỉ của tôi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Địa chỉ giao hàng</h1>
            <a href="{{ route('addresses.create') }}" class="bg-orange-500 text-white px-5 py-2 rounded-xl font-semibold hover:bg-orange-600 transition">
                + Thêm mới
            </a>
        </div>

        @if($addresses->count())
            <div class="space-y-4">
                @foreach($addresses as $address)
                    <div class="bg-white rounded-2xl shadow-sm p-5 flex justify-between items-center">
                        <div>
                            <p class="font-semibold">{{ $address->recipient_name }}</p>
                            <p class="text-gray-600 text-sm">{{ $address->phone_number }}</p>
                            <p class="text-gray-700 mt-1">{{ $address->full_address }}</p>
                            @if($address->is_default)
                                <span class="inline-block mt-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Mặc định</span>
                            @endif
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('addresses.edit', $address) }}" class="text-blue-500 hover:underline text-sm font-medium">Sửa</a>
                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Xóa địa chỉ này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-sm font-medium">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500 mb-4">Bạn chưa có địa chỉ nào.</p>
                <a href="{{ route('addresses.create') }}" class="text-orange-500 underline font-medium">Thêm địa chỉ mới</a>
            </div>
        @endif
    </div>
</div>
@endsection