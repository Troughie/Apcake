<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;
    protected $primaryKey = 'review_id';

    protected $table = 'reviews';
    public function user_review(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product_comment(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
