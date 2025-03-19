<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewToken extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'url', 'user_id', 'is_used', 'expires_at'];

    protected $casts = [
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Relationship with User (Optional)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the token is valid (not used and not expired)
     */
    public function isValid(): bool
    {
        return !$this->is_used && (!$this->expires_at || $this->expires_at->isFuture());
    }
}
