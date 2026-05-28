@extends('layouts.app')
@section('title', 'Danh sách yêu thích')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Mèo yêu thích</h1>
    @if($wishlistItems->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlistItems as $item)
                <x-product-card :cat="$item->cat" />
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Chưa có mèo yêu thích nào.</p>
    @endif
</div>
@endsection