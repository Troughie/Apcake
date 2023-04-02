<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    use HasFactory;

    protected $primaryKey = 'promotion_id';

    protected $table = 'promotions';


    protected $fillable = [
        'code',
        'discountAmount',
        'discountQuantity',
        'startDate',
        'endDate',
        'product_id',
        'status',
    ];

    public function orderCoup(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'promotion_id');
    }
}
