<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'status_id';

    protected $table = 'order_status';

    protected $fillable = [
        'name',
        'description'
    ];

    public function order(): HasMany
    {
        return $this->HasMany(Order::class, 'status_id');
    }
}
