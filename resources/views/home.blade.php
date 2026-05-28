@extends('layouts.app')
@section('title', 'CatShop - Mua bán mèo cảnh')

@section('content')
<!-- Hero -->
<section class="bg-gradient-to-r from-orange-100 to-pink-100 py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-800 mb-4">
            Tìm người bạn <span class="text-orange-500">mèo cưng</span> lý tưởng
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Hàng trăm bé mèo thuần chủng, sức khỏe tốt, bảo hành đầy đủ. Đặt mua dễ dàng.</p>
        <a href="{{ route('cats.index') }}" class="inline-block bg-orange-500 text-white px-8 py-4 rounded-full text-lg font-semibold shadow-lg hover:bg-orange-600 transition">
            Khám phá ngay
        </a>
    </div>
</section>

<section class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Mèo nổi bật</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($featuredCats as $cat)
            <x-product-card :cat="$cat" />
        @endforeach
    </div>
    <div class="text-center mt-10">
        <a href="{{ route('cats.index') }}" class="inline-block border-2 border-orange-500 text-orange-500 px-8 py-3 rounded-full font-semibold hover:bg-orange-500 hover:text-white transition">
            Xem tất cả
        </a>
    </div>
</section>
@endsection