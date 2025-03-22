<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'colors_id',
        'sizes_id',
        'materials_id',
        'type_id',
        'sku',
        'name',
        'description',
        'meta_keywords',
        'price',
        'status',
        'featured',
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
