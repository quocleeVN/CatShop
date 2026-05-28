<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, MustVerifyEmailTrait, Notifiable;

    /**
     * Khóa chính của bảng.
     */
    protected $primaryKey = 'user_id';

    /**
     * Các trường có thể gán hàng loạt.
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone_number',
        'role',
        'is_active',
    ];

    /**
     * Các trường ẩn khi serialize.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu cho các thuộc tính.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->full_name,
            set: fn (string $value) => ['full_name' => $value],
        );
    }

    protected function id(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user_id,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Quan hệ
    |--------------------------------------------------------------------------
    */

    /**
     * Địa chỉ của user.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class, 'user_id');
    }

    /**
     * Đơn hàng của user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Giỏ hàng (cart) của user.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }

    /**
     * Đánh giá của user.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * Danh sách yêu thích (wishlist) của user.
     */
    public function wishlistItems(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    /**
     * Kiểm tra user có phải admin không.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Lấy địa chỉ mặc định của user.
     */
    public function defaultAddress(): ?UserAddress
    {
        return $this->addresses()->where('is_default', true)->first();
    }

    /**
     * Kiểm tra user đã nhận sản phẩm này hay chưa.
     */
    public function hasPurchasedCat(int $catId): bool
    {
        return $this->orders()
            ->where('order_status', 'delivered')
            ->whereHas('items', function (Builder $query) use ($catId) {
                $query->where('cat_id', $catId);
            })
            ->exists();
    }
}
