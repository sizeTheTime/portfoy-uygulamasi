<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'content_type', // <-- ekledim
        'featured_image',
        'featured_image_alt',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
    ];
}
