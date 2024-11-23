<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
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
        'products_id',
    ];

    /**
    * Get the images.
    */
    public function Products()
    {
        return $this->belongsToMany(Products::class,  'product_product_images', 'product_images_id', 'products_id');
    }
}
