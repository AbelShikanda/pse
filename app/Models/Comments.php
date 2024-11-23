<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    // protected $fillable = ['blog_id', 'user_id', 'content'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_id',
        'user_id',
        'content',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class,  'blog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
