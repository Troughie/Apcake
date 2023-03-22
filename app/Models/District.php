<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        '_name',
        '_prefix',
    ];

    protected $table = 'district';

    public function province(): BelongsTo
    {
        return $this->BelongsTo(Province::class);
    }
}
