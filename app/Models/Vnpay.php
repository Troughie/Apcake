<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vnpay extends Model
{
    use HasFactory;


    protected $table = 'vnpay';

    protected $fillable = [
        'Amount',
        'order_id',
        'OrderInfo',
        'BankCode',
    ];
    public function orderPay(): BelongsTo
    {
        return $this->BelongsTo(Order::class, 'order_id');
    }
}
