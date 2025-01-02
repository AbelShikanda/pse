<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorJourney extends Model
{
    use HasFactory;
    
    const EVENT_TYPE_PAGE_VISIT = 'page_visit';
    const EVENT_TYPE_BUTTON_CLICK = 'button_click';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visitor_data_id',
        'event_type',
        'page_url',
        'button_clicked',
    ];
    
    /**
    * Get the orders.
    */
    public function visitorData()
    {
        return $this->belongsTo(VisitorData::class);
    }

    /**
     * Accessor for the event type.
     *
     * @param  string  $value
     * @return string
     */
    public function getEventTypeAttribute($value)
    {
        return ucfirst(str_replace('_', ' ', $value)); // Just to make it more readable (optional)
    }
}
