<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Medicine extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'image',
        'price',
        'stock',
    ];

    // المنتج موجود في كام cart
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // المنتج موجود في كام order
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
