<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'country',
        'region',
        'city',
        'referrer',
        'user_agent',
        'utm_source',
        'utm_medium',
        'utm_campaign',
    ];

    public function VisitorJourney()
    {
        return $this->hasMany(VisitorJourney::class);
    }
}
