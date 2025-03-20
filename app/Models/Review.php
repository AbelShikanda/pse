<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'token', 'user_id', 'review', 'rating', 'guest_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
