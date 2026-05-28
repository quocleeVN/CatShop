<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-orange-500 flex items-center">
                <span class="text-3xl mr-1">🐱</span> CatShop
            </a>
            <!-- Desktop menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-500 font-medium">Trang chủ</a>
                <a href="{{ route('cats.index') }}" class="text-gray-700 hover:text-orange-500 font-medium">Mèo cảnh</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-orange-500 font-medium">Giới thiệu</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-orange-500 font-medium">Liên hệ</a>
                @auth
                    <a href="{{ route('wishlist.index') }}" class="relative text-gray-700 hover:text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span class="absolute -top-2 -right-3 bg-pink-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ auth()->user()->wishlistItems()->count() }}
                        </span>
                    </a>
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <span class="absolute -top-2 -right-3 bg-orange-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center cart-count">
                            {{ app(App\Services\CartService::class)->getCartCount() }}
                        </span>
                    </a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-700 hover:text-orange-500">
                            <span class="mr-1">{{ auth()->user()->full_name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-50">Hồ sơ</a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-orange-50">Đơn hàng</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-gray-700 hover:bg-orange-50">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-500 font-medium">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition">Đăng ký</a>
                @endauth
            </div>
            <!-- Mobile menu button -->
            <button id="mobile-menu-toggle" class="md:hidden text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-4 py-3 space-y-3">
            <a href="{{ route('home') }}" class="block text-gray-700">Trang chủ</a>
            <a href="{{ route('cats.index') }}" class="block text-gray-700">Mèo cảnh</a>
            <a href="{{ route('about') }}" class="block text-gray-700">Giới thiệu</a>
            <a href="{{ route('contact') }}" class="block text-gray-700">Liên hệ</a>
            @auth
                <a href="{{ route('wishlist.index') }}" class="block text-gray-700">Yêu thích</a>
                <a href="{{ route('cart.index') }}" class="block text-gray-700">Giỏ hàng</a>
                <a href="{{ route('profile.edit') }}" class="block text-gray-700">Hồ sơ</a>
                <a href="{{ route('orders.index') }}" class="block text-gray-700">Đơn hàng</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block text-gray-700">Đăng xuất</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-gray-700">Đăng nhập</a>
                <a href="{{ route('register') }}" class="block text-gray-700">Đăng ký</a>
            @endauth
        </div>
    </div>
</nav>
@push('scripts')
<script>
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@endpush