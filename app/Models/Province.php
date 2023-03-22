<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{

    use HasFactory;

    protected $fillable = [
        '_name',
        '_code',
    ];

    protected $table = 'province';

    public function district(): HasMany
    {
        return $this->hasMany(District::class, '_province_id');
    }

    public function ward(): HasMany
    {
        return $this->hasMany(Ward::class, '_province_id');
    }
}
