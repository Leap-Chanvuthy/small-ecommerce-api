<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order ; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order(): BelongsTo
{
    return $this->belongsTo(Order::class, 'order_id');
}
public function product(): BelongsTo
{
    return $this->belongsTo(OrderItem::class, 'order_id');
}
   
}
