<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';

    public $timestamps = false; // bảng không có timestamps

    protected $fillable = [
        'order_id',
        'cat_id',
        'price_at_purchase',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'price_at_purchase' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Quan hệ
    |--------------------------------------------------------------------------
    */

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class, 'cat_id');
    }
}
