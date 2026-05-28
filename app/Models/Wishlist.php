<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $primaryKey = 'wishlist_id';

    public $timestamps = false; // bảng chỉ có created_at, ta muốn giữ nó? Migration dùng created_at với useCurrent, không cần Eloquent tự động set. Vậy timestamps=false là được, nhưng nếu muốn tự động set khi tạo, có thể kích hoạt và dùng const UPDATED_AT = null. Để đơn giản, tôi để timestamps=false vì DB tự gán, không cần model điền. Tuy vậy khi tạo record, Eloquent sẽ không set created_at, nhưng DB sẽ lấy CURRENT_TIMESTAMP nếu không truyền. Có thể bỏ qua.

    protected $fillable = [
        'user_id',
        'cat_id',
    ];

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
