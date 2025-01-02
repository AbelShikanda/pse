<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogImages extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'thumbnail',
        'full',
        'blogs_id',
    ];

    /**
    * Get the blogs.
    */
    public function blogs()
    {
        return $this->belongsToMany(Blog::class,  'blog_blog_images', 'blog_images_id', 'blogs_id');
    }
}
