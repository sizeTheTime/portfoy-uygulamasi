<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
    ];

    // Bir ürün bir kategoriye aittir
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Bir ürünün birden fazla resmi olabilir
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Bir ürünün birden fazla kart resmi olabilir
    public function cardImages()
    {
        return $this->hasMany(CardImage::class);
    }

    // Bir ürünün tek bir kart resmi olabilir
    public function cardImage()
    {
        return $this->hasOne(CardImage::class);
    }

    // Bir ürünün birden fazla rengi olabilir (pivot tablo üzerinden)
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    // Bir ürünün birden fazla özelliği olabilir
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
