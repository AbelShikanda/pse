<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCodeUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'promo_code_id',
        'user_id',
    ];

    /**
     * Get the promo code associated with this usage record.
     */
    public function promoCode()
    {
        return $this->belongsTo(PromoCodes::class, 'promo_code_id');
    }

    /**
     * Get the user who used this promo code.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
