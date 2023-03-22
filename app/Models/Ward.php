<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ward extends Model
{
    use HasFactory;
    protected $fillable = [
        '_name',
        '_prefix',
    ];

    protected $table = 'ward';

    public function province(): BelongsTo
    {
        return $this->BelongsTo(Province::class);
    }
}
