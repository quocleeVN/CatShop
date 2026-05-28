@props(['cat'])

<div class="product-card bg-white rounded-2xl shadow-md overflow-hidden group hover:shadow-xl transition-all duration-300">
    <div class="relative overflow-hidden">
        <img src="{{ $cat->link_image ?? asset('images/placeholder-cat.jpg') }}" 
             alt="{{ $cat->name }}" 
             class="w-full h-56 object-cover group-hover:scale-105 transition duration-500"
             loading="lazy">
        @if($cat->stock_status != 'available')
            <div class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full">
                {{ $cat->stock_status == 'sold' ? 'Đã bán' : 'Đã đặt' }}
            </div>
        @endif
    </div>
    <div class="p-4">
        <div class="flex justify-between items-start mb-2">
            <h3 class="font-bold text-lg text-gray-800">{{ $cat->name }}</h3>
            <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full">{{ $cat->breed->breed_name }}</span>
        </div>
        <p class="text-gray-500 text-sm mb-2">{{ $cat->gender == 'male' ? 'Đực' : 'Cái' }} · {{ $cat->age_in_months }} tháng</p>
        <div class="flex justify-between items-center">
            <span class="text-orange-600 font-bold text-lg">{{ number_format($cat->price, 0, ',', '.') }}đ</span>
            @auth
                <button type="button" class="text-gray-400 hover:text-pink-500 wishlist-toggle ml-2" data-cat-id="{{ $cat->cat_id }}" data-url="{{ route('wishlist.toggle', $cat) }}" aria-pressed="{{ auth()->user()->wishlistItems()->where('cat_id', $cat->cat_id)->exists() ? 'true' : 'false' }}">
                    <svg class="w-5 h-5" fill="{{ auth()->user()->wishlistItems()->where('cat_id', $cat->cat_id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>
            @endauth
        </div>
        <a href="{{ route('cats.show', $cat) }}" class="mt-3 block w-full text-center bg-orange-500 text-white py-2 rounded-xl hover:bg-orange-600 transition font-medium">
            Xem chi tiết
        </a>
    </div>
</div>