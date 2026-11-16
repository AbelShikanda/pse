<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'promo_code_id',
        'reference',
        'tracking_No',
        'price',
        'complete',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'complete' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(Order_Items::class, 'order_id');
    }

    // Assuming each order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with PromoCode
    public function promoCode()
    {
        return $this->belongsTo(PromoCodes::class, 'promo_code_id');
    }
}
