<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'order_id';

    protected $table = 'orders';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coupon(): HasOne
    {
        return $this->HasOne(Promotion::class, 'promotion_id');
    }

    public function orderDe(): HasMany
    {
        return $this->HasMany(OrderDetails::class, 'order_id');
    }

    public function products(): HasManyThrough
    {
        return $this->HasManyThrough(Product::class, OrderDetails::class, 'order_id', 'product_id');
    }

    public function order_sta(): BelongsTo
    {
        return $this->BelongsTo(OrderStatus::class, 'status_id');
    }


    public function payorder(): HasMany
    {
        return $this->HasMany(Vnpay::class, 'order_id');
    }

    protected $fillable = [
        'order_date',
        'totalAmount'
    ];
}