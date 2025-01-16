<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Items extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'color_id',
        'size_id',
        'price',
        'quantity',
    ];
    
    /**
    * Get the orders.
    */
    public function orders()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
    
    /**
    * Get the products.
    */
    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    
    /**
    * Get the Size.
    */
    public function size()
    {
        return $this->belongsTo(ProductSizes::class);
    }
    
    /**
    * Get the Color.
    */
    public function color()
    {
        return $this->belongsTo(ProductColors::class);
    }
}
