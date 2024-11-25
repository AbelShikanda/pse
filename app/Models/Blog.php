<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasFactory, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_categories_id',
        'title',
        'sub_title',
        'body',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
    * Get the images.
    */
    public function BlogImage()
    {
        return $this->belongsToMany(BlogImages::class, 'blog_blog_images', 'blogs_id', 'blog_images_id');
    }

    /**
    * Get the Category.
    */
    public function blogCategories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_blog_categories', 'blogs_id', 'blog_categories_id');
    }

    /**
    * Get the comments.
    */
    public function comments()
    {
        return $this->hasMany(Comments::class, 'blog_id');
    }
}
