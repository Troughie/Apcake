<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Size extends Model
{
    use HasFactory;
    protected $primaryKey = 'size_id';
    protected $fillable = [
        'product_id',
        'size',
        'price',
        'instock',


    ];
    public function productSize(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}