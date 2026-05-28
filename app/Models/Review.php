<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey = 'review_id';

    public $timestamps = false; // chỉ có created_at, nhưng ta muốn giữ `created_at`? Có cột `created_at` trong schema, nhưng không có updated_at. Vậy cần chỉ định const UPDATED_AT = null, và giữ timestamps = false? Nếu timestamps=false thì Eloquent không tự động set created_at. Nhưng trong migration ta đã set default `useCurrent`, nên không cần Eloquent set. Ta đặt `public $timestamps = false;` để không yêu cầu updated_at.

    const UPDATED_AT = null; // không sử dụng updated_at, nhưng cần giữ timestamps = true để tự động set created_at? Thực tế, nếu ta muốn Eloquent tự động điền created_at khi create, ta nên set `public $timestamps = true;` và chỉ rõ `const UPDATED_AT = null;`. Để an toàn, tôi sẽ enable timestamps và set UPDATED_AT = null.


    protected $fillable = [
        'user_id',
        'cat_id',
        'rating',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'created_at' => 'datetime',
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
