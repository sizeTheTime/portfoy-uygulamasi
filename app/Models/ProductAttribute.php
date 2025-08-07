<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'value'];

    // Her özellik bir ürüne aittir
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
