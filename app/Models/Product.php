<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Review;
class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'id',  
        'name',
        'description',
        'price',
        'sku',
        'stock_quantity',
        'created_at',
        'updated_at',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
