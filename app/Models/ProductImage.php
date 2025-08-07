<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'main_image', 'hover_image', 'main_image_alt', 'hover_image_alt'];

    // Her resim bir ürüne aittir
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
