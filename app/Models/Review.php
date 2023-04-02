<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    use HasFactory;
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'product_id', 'user_id',
        'rating',
        'comment',
        '_token',
        'status'
    ];
    protected $table = 'reviews';
    public function user_review(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product_comment(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function feedback(): HasOne
    {
        return $this->HasOne(Feedback::class, 'review_id');
    }
}
