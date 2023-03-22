<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ranking extends Model
{
    use HasFactory;
    protected $primaryKey = 'rank_id';

    protected $table = 'rankings';
    public function user_rank(): HasMany
    {
        return $this->hasMany(User::class, 'rank_id');
    }
}
