<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        // 'sort_order', // Artık formdan gelmeyecek, modelde otomatik ayarlanacak
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
    ];

    // Varsayılan olarak sort_order'ı 0 yap
    protected static function booted()
    {
        static::creating(function ($category) {
            if (is_null($category->sort_order)) {
                $category->sort_order = 0;
            }
        });
    }

    // Bir kategorinin birden fazla resmi olabilir
    public function images()
    {
        return $this->hasMany(CategoryImage::class);
    }

    // Bir kategorinin bir adet ana resmi olabilir (one to one)
    public function image()
    {
        return $this->hasOne(CategoryImage::class);
    }


    // Bir kategorinin birden fazla ürünü olabilir
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
