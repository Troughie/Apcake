<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'category_id';
    protected $table = 'categories';

    protected $fillable = [
        'category_name'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function product(){
        return $this->hasMany(Product::class,'product_id');
    }
}
