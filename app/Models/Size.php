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
        'size_id',
        'product_id',
        'size',
        'price',
        

    ];
    public function productSize(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'size_id');
    }
}
