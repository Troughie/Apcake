<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class OrderDetails extends Model
{
    use HasFactory;

    protected $primaryKey = 'orderdetail_id';

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'total',
        'size'
    ];

    public function order_pro(): BelongsTo
    {
        return $this->BelongsTo(Product::class, 'product_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item_sta(): HasManyThrough
    {
        return $this->HasManyThrough(OrderStatus::class, Order::class, 'order_id', 'status_id');
    }
}
