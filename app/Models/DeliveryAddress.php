<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryAddress extends Model
{
    use HasFactory;
    protected $primaryKey = 'delivery_id';

    protected $table = 'delivery_addresses';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable = [
        'fullname',
        'phone',
        'province',
        'district',
        'ward',
    ];
}
