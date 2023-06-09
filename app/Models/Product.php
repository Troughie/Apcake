<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'image',
        'status',

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

    public function orderdetails(): HasMany
    {
        return $this->HasMany(OrderDetails::class, 'product_id');
    }

    public function favorites(): HasMany
    {
        return $this->HasMany(Favorite::class, 'product_id');
    }

    public function product_review(): HasMany
    {
        return $this->HasMany(Review::class, 'review_id');
    }

    public function product_size(): HasMany
    {
        return $this->HasMany(Size::class, 'product_id');
    }
}
