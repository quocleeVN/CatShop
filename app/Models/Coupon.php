<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $primaryKey = 'coupon_id';

    public $timestamps = false; // chỉ có created_at, nhưng ta cần `created_at`? Để đơn giản, nếu muốn giữ created_at thì khai báo const UPDATED_AT = null. Tuy nhiên migration của ta chỉ có created_at, không có updated_at. Nên cần chỉ định const UPDATED_AT = null.

    const UPDATED_AT = null;

    protected $fillable = [
        'code',
        'discount_percent',
        'max_discount',
        'min_order_value',
        'expiry_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'discount_percent' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'min_order_value' => 'decimal:2',
            'expiry_date' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Quan hệ
    |--------------------------------------------------------------------------
    */

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'coupon_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('expiry_date', '>=', Carbon::now());
    }

    /**
     * Kiểm tra xem mã có hợp lệ không.
     */
    public function isValid(): bool
    {
        return $this->is_active && $this->expiry_date >= Carbon::now();
    }

    /**
     * Tính số tiền giảm giá dựa trên tổng đơn hàng.
     */
    public function calculateDiscount(float $orderTotal): float
    {
        if (!$this->isValid()) {
            return 0;
        }
        $discount = $orderTotal * ($this->discount_percent / 100);
        if ($this->max_discount && $discount > $this->max_discount) {
            $discount = $this->max_discount;
        }
        return round($discount, 2);
    }
}
