<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Products extends Model
{
    use HasFactory, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['categories_id', 'colors_id', 'sizes_id', 'materials_id', 'type_id', 'name', 'slug', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'meta_image', 'price'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
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
     * Get the ProductType.
     */
    public function ProductType()
    {
        return $this->belongsToMany(ProductTypes::class, 'product_product_types', 'products_id', 'product_types_id');
    }

    /**
     * Get the images.
     */
    public function ProductImage()
    {
        return $this->belongsToMany(ProductImages::class, 'product_product_images', 'products_id', 'product_images_id');
    }

    /**
     * Get the Category.
     */
    public function Category()
    {
        return $this->belongsToMany(ProductCategories::class, 'product_product_categories', 'products_id', 'product_categories_id');
    }

    /**
     * Get the Size.
     */
    public function Size()
    {
        return $this->belongsToMany(ProductSizes::class, 'product_product_sizes', 'products_id', 'product_sizes_id');
    }

    /**
     * Get the Color.
     */
    public function Color()
    {
        return $this->belongsToMany(ProductColors::class, 'product_product_colors', 'products_id', 'product_colors_id');
    }

    /**
     * Get the Material.
     */
    public function Material()
    {
        return $this->belongsToMany(ProductMaterials::class, 'product_product_materials', 'products_id', 'product_materials_id');
    }

    /**
     * The attributes that should be cast.
     */
    public function orderItems()
    {
        return $this->belongsToMany(Order_Items::class);
    }

    public function ratings()
    {
        return $this->hasMany(Ratings::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}
