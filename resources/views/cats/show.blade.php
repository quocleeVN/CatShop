@extends('layouts.app')
@section('title', $cat->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 gap-10 rounded-2xl bg-white p-6 shadow-sm md:grid-cols-2">
        <div>
            <img src="{{ $cat->link_image ?? asset('images/placeholder-cat.jpg') }}" alt="{{ $cat->name }}" class="h-96 w-full rounded-2xl object-cover">
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $cat->name }}</h1>
            <p class="mt-2 text-lg font-bold text-orange-500">{{ number_format($cat->price, 0, ',', '.') }}đ</p>

            <div class="mt-4 space-y-2">
                <p><span class="font-semibold">Giống:</span> {{ $cat->breed->breed_name }}</p>
                <p><span class="font-semibold">Tuổi:</span> {{ $cat->age_in_months }} tháng</p>
                <p><span class="font-semibold">Giới tính:</span> {{ $cat->gender == 'male' ? 'Đực' : 'Cái' }}</p>
                <p><span class="font-semibold">Màu sắc:</span> {{ $cat->color ?? 'Chưa rõ' }}</p>
                <p><span class="font-semibold">Cân nặng:</span> {{ $cat->weight }} kg</p>
                <p><span class="font-semibold">Sức khỏe:</span> {{ $cat->health_status }}</p>
                <p><span class="font-semibold">Tiêm phòng:</span> {{ $cat->is_vaccinated ? 'Đã tiêm' : 'Chưa tiêm' }}</p>
            </div>

            @if($cat->stock_status == 'available')
                <form action="{{ route('cart.add') }}" method="POST" class="mt-6 flex space-x-3">
                    @csrf
                    <input type="hidden" name="cat_id" value="{{ $cat->cat_id }}">
                    <input type="number" name="quantity" value="1" min="1" max="5" class="w-20 rounded-xl border-gray-300 text-center">
                    <button type="submit" class="rounded-xl bg-orange-500 px-6 py-2 font-semibold text-white hover:bg-orange-600">
                        Thêm vào giỏ hàng
                    </button>
                </form>
            @else
                <button disabled class="mt-6 cursor-not-allowed rounded-xl bg-gray-400 px-6 py-2 text-white">Hết hàng</button>
            @endif

            @auth
                <button type="button" class="w-full rounded-xl border border-pink-500 bg-white px-6 py-2 font-medium text-pink-500 hover:bg-pink-50 mt-3 wishlist-toggle" id="wishlist-btn" data-cat-id="{{ $cat->cat_id }}" data-url="{{ route('wishlist.toggle', $cat) }}" aria-pressed="{{ auth()->user()->wishlistItems()->where('cat_id', $cat->cat_id)->exists() ? 'true' : 'false' }}">
                    <span class="wishlist-label">
                        @if(auth()->user()->wishlistItems()->where('cat_id', $cat->cat_id)->exists())
                            Đã thích
                        @else
                            Thêm vào yêu thích
                        @endif
                    </span>
                </button>
            @endauth
        </div>
    </div>

    <div class="mt-10 rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-2xl font-bold">Mô tả</h2>
        <p class="text-gray-700">{{ $cat->description ?? 'Chưa có mô tả.' }}</p>
    </div>

    <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-2xl font-bold">Đánh giá ({{ $cat->reviews->count() }})</h2>

        @forelse($cat->reviews as $review)
            <div class="border-b py-3 last:border-b-0">
                <div class="flex items-center space-x-2">
                    <span class="font-semibold">{{ $review->user->full_name }}</span>
                    <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                    <span class="text-sm text-gray-500">{{ $review->created_at?->format('d/m/Y') }}</span>
                </div>
                <p class="mt-1">{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-gray-600">Chưa có đánh giá nào cho sản phẩm này.</p>
        @endforelse

        @auth
            @if($canReview)
                <form action="{{ route('reviews.store', $cat) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-3 flex items-center space-x-2">
                        <select name="rating" class="rounded-xl border-gray-300" required>
                            <option value="5">5 ⭐</option>
                            <option value="4">4 ⭐</option>
                            <option value="3">3 ⭐</option>
                            <option value="2">2 ⭐</option>
                            <option value="1">1 ⭐</option>
                        </select>
                    </div>
                    <textarea name="comment" rows="3" class="w-full rounded-xl border-gray-300" placeholder="Chia sẻ cảm nhận..."></textarea>
                    <button type="submit" class="mt-2 rounded-xl bg-orange-500 px-4 py-2 text-white hover:bg-orange-600">Gửi đánh giá</button>
                </form>
            @else
                <p class="mt-4 rounded-xl bg-gray-50 px-4 py-3 text-sm text-gray-600">
                    Bạn cần mua và nhận sản phẩm này trước khi có thể đánh giá. Bạn vẫn có thể xem các đánh giá từ người dùng khác.
                </p>
            @endif
        @endauth
    </div>
</div>
@endsection
