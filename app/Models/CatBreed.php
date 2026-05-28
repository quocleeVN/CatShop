<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatBreed extends Model
{
    use HasFactory;

    protected $primaryKey = 'breed_id';

    /**
     * Không có timestamps `updated_at`.
     */
    public $timestamps = false;

    protected $fillable = [
        'breed_name',
        'origin',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | Quan hệ
    |--------------------------------------------------------------------------
    */

    public function cats(): HasMany
    {
        return $this->hasMany(Cat::class, 'breed_id');
    }
}
