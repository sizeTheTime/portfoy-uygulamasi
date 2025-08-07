<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blog;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index()
    {
        // Kategorileri ilişkili resimleriyle birlikte al
        $categories = Category::all();

        return view('pages.home', compact('categories'));
    }

    public function showProduct($category_slug, $product_slug)
    {
        // Ürünü slug ile getir
        $product = Product::where('slug', $product_slug)
            ->with([
                'images' => function ($query) {
                    $query->orderBy('id')->limit(4);
                },
                'cardImages',
                'colors',
                'attributes'
            ])
            ->firstOrFail();

        $totalImagesCount = Product::where('slug', $product_slug)->first()->images()->count();
        $hasMoreImages = $totalImagesCount > 4;

        // Structured Data for single product
        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $product->name,
            "sku" => $product->sku,
            "description" => $product->description,
            "image" => $product->cardImage->main_image ? asset('storage/' . $product->cardImage->main_image) : null,
            "url" => URL::route('product.show', ['category_slug' => $category_slug, 'product_slug' => $product_slug]),
            "offers" => [
                "@type" => "Offer",
                "price" => $product->price,
                "priceCurrency" => "TRY",
                "availability" => "https://schema.org/InStock"
            ]
        ];



        return view('pages.products.show', compact('product', 'totalImagesCount', 'hasMoreImages', 'structuredData'));
    }

    public function showCategory($category_slug)
    {
        $category = Category::with(['products', 'image'])->where('slug', $category_slug)->firstOrFail();

        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "CollectionPage",
            "name" => $category->name,
            "description" => $category->short_description ?? $category->description,
            "image" => $category->image ? asset('storage/' . $category->image->image_path) : null,
            "mainEntity" => $category->products->map(function ($product) use ($category) {
                return [
                    "@type" => "Product",
                    "name" => $product->name,
                    "sku" => $product->sku,
                    "description" => $product->description,
                    "url" => URL::route('product.show', ['category_slug' => $category->slug, 'product_slug' => $product->slug]),
                    "offers" => [
                        "@type" => "Offer",
                        "price" => $product->price,
                        "priceCurrency" => "TRY",
                        "availability" => $product->stock > 0 ? "https://schema.org/InStock" : "https://schema.org/OutOfStock"
                    ]
                ];
            })->values()
        ];

        return view('pages.category.show', compact('category', 'structuredData'));
    }

    public function loadMoreImages(Request $request, $product_slug)
    {
        $offset = $request->get('offset', 4);
        $limit = $request->get('limit', 4);

        $product = Product::where('slug', $product_slug)->firstOrFail();

        $images = $product->images()
            ->orderBy('id')
            ->skip($offset)
            ->take($limit)
            ->get();

        $totalCount = $product->images()->count();
        $hasMore = ($offset + $limit) < $totalCount;

        return response()->json([
            'images' => $images,
            'hasMore' => $hasMore,
            'totalCount' => $totalCount,
        ]);
    }

    public function sitemap()
    {
        $categories = Category::with('products')->get();

        // Sadece kart için gerekli blog alanlarını al
        $blogs = Blog::select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at')
            ->orderByDesc('published_at')
            ->limit(9)
            ->get();

        return view('pages.sitemap', compact('categories', 'blogs'));
    }

    public function blogs()
    {
        $blogs = Blog::select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at')
            ->orderByDesc('published_at')
            ->paginate(9);

        // Tüm bloglar için structured data array'i oluştur
        $structuredData = [
            "@context" => "https://schema.org",
            "@graph" => []
        ];

        foreach ($blogs as $blog) {
            $structuredData["@graph"][] = [
                "@type" => "BlogPosting",
                "headline" => $blog->title,
                "description" => $blog->excerpt,
                "image" => $blog->featured_image ? asset('storage/' . $blog->featured_image) : null,
                "datePublished" => $blog->published_at,
                "mainEntityOfPage" => [
                    "@type" => "WebPage",
                    "@id" => route('web.blogs.show', ['slug' => $blog->slug])
                ]
            ];
        }

        return view('pages.blog', compact('blogs', 'structuredData'));
    }

    public function blog($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->select('id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'published_at')
            ->firstOrFail();

        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "BlogPosting",
            "headline" => $blog->title,
            "description" => $blog->excerpt,
            "image" => $blog->featured_image ? asset('storage/' . $blog->featured_image) : null,
            "datePublished" => $blog->published_at,
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => URL::route('web.blogs.show', ['slug' => $blog->slug])
            ]
        ];

        return view('pages.blog-show', compact('blog', 'structuredData'));
    }
}
