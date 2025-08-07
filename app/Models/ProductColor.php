<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color_id'];

    // Her kayıt bir ürüne aittir
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Her kayıt bir renge aittir
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
