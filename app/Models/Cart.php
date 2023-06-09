<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = 'cart_id';
    protected $table = 'carts';

    protected $fillable = [
        'quantity',
        'size',
    ];

    public function cart_pro(): BelongsTo
    {
        return $this->BelongsTo(Product::class, 'product_id');
    }

    public function cart_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
