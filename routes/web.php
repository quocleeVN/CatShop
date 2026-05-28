<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CatController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CatController as AdminCatController;
use App\Http\Controllers\Admin\BreedController as AdminBreedController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/cats', [CatController::class, 'index'])->name('cats.index');
Route::get('/cats/{cat}', [CatController::class, 'show'])->name('cats.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cat_id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cat_id}', [CartController::class, 'remove'])->name('cart.remove');

    // Thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

    // Đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Yêu thích
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{cat}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Đánh giá
    Route::post('/reviews/{cat}', [ReviewController::class, 'store'])->name('reviews.store');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Địa chỉ
    Route::resource('/addresses', UserAddressController::class)->except(['show'])->names([
        'index'   => 'addresses.index',
        'create'  => 'addresses.create',
        'store'   => 'addresses.store',
        'edit'    => 'addresses.edit',
        'update'  => 'addresses.update',
        'destroy' => 'addresses.destroy',
    ]);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Quản lý mèo
    Route::resource('cats', AdminCatController::class)->names([
        'index'   => 'cats.index',
        'create'  => 'cats.create',
        'store'   => 'cats.store',
        'show'    => 'cats.show',
        'edit'    => 'cats.edit',
        'update'  => 'cats.update',
        'destroy' => 'cats.destroy',
    ]);

    // Quản lý giống mèo
    Route::resource('breeds', AdminBreedController::class)->except(['show'])->names([
        'index'   => 'breeds.index',
        'create'  => 'breeds.create',
        'store'   => 'breeds.store',
        'edit'    => 'breeds.edit',
        'update'  => 'breeds.update',
        'destroy' => 'breeds.destroy',
    ]);

    // Quản lý người dùng
    Route::resource('users', AdminUserController::class)->except(['show'])->names([
        'index'   => 'users.index',
        'create'  => 'users.create',
        'store'   => 'users.store',
        'edit'    => 'users.edit',
        'update'  => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    // Quản lý đơn hàng
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show'])->names([
        'index' => 'orders.index',
        'show'  => 'orders.show',
    ]);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Quản lý mã giảm giá
    Route::resource('coupons', AdminCouponController::class)->except(['show'])->names([
        'index'   => 'coupons.index',
        'create'  => 'coupons.create',
        'store'   => 'coupons.store',
        'edit'    => 'coupons.edit',
        'update'  => 'coupons.update',
        'destroy' => 'coupons.destroy',
    ]);

    // Quản lý đánh giá
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy'])->names([
        'index'   => 'reviews.index',
        'destroy' => 'reviews.destroy',
    ]);
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'admin']);

require __DIR__ . '/auth.php';
