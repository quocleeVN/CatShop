<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';

    public $timestamps = false; // bảng không có timestamps

    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone_number',
        'specific_address',
        'ward',
        'district',
        'city',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Quan hệ
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Trả về địa chỉ đầy đủ dưới dạng chuỗi.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->specific_address,
            $this->ward,
            $this->district,
            $this->city,
        ]);
        return implode(', ', $parts);
    }
}
