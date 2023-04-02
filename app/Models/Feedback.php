<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    use HasFactory;

    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'content',
        'review_id',
        'feedback_admin'
    ];
    protected $table = 'feedback_review';

    public function feedback(): BelongsTo
    {
        return $this->BelongsTo(Review::class, 'review_id');
    }
}
