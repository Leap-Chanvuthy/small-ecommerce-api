<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category ; 
use App\Models\Cart ; 
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function card(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
    public function review(): HasMany
    {
        return $this->hasMany(Review::class);
    }
    public function order_item(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
