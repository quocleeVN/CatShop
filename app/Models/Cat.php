<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cat extends Model
{
    use HasFactory;

    protected $primaryKey = 'cat_id';

    protected $fillable = [
        'breed_id',
        'name',
        'price',
        'age_in_months',
        'gender',
        'color',
        'weight',
        'description',
        'health_status',
        'is_vaccinated',
        'stock_status',
        'link_image',
    ];

    protected function casts(): array
    {
        return [
            'is_vaccinated' => 'boolean',
            'price' => 'decimal:2',
            'weight' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Quan hệ
    |--------------------------------------------------------------------------
    */

    public function breed(): BelongsTo
    {
        return $this->belongsTo(CatBreed::class, 'breed_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cat_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'cat_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'cat_id');
    }

    public function wishlistedBy(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'cat_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Chỉ lấy mèo đang có sẵn.
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock_status', 'available');
    }

    /**
     * Lọc theo giống mèo.
     */
    public function scopeOfBreed($query, $breedId)
    {
        return $query->where('breed_id', $breedId);
    }

    /**
     * Lọc theo khoảng giá.
     */
    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }
}
