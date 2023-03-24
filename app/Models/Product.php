<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name',
        'price',
        'description',
        'quantity',
        'image'
    ];

    protected $table = 'products';

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function cart(): HasMany
    {
        return $this->HasMany(Cart::class, 'product_id');
    }
    public function product_review(): HasMany
    {
        return $this->HasMany(Review::class, 'review_id');
    }
}
