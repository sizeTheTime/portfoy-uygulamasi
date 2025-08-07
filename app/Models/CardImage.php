<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'main_image',
        'secondary_image',
        'main_image_alt',
        'secondary_image_alt',
        'description',
        'sort_order',
    ];

    // Her kart resmi bir ürüne aittir
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
