<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id';

    public $timestamps = false; // bảng này chỉ có created_at, nhưng dùng timestamp `useCurrent`, ta có thể để timestamps=true với `updated_at` mặc định không tồn tại -> lỗi. Vậy cần chỉ rõ `const UPDATED_AT = null`.

    const UPDATED_AT = null; // bảng không có updated_at

    protected $fillable = [
        'user_id',
        'cat_id',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
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

    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class, 'cat_id');
    }
}
