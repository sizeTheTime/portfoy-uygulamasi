<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Color;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        // Sadece cardImages ilişkisi ile ürünleri getir, eskiye göre sıralama tam tersi (en eski ilk)
        $products = Product::with('cardImage')->oldest()->get();

        return Inertia::render('pages/index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $colors = Color::select('id', 'name', 'hex_code')->get();

        // Vue tarafında kolay kullanım için dizi olarak gönder
        return Inertia::render('pages/create', [
            'categories' => $categories,
            'colors' => $colors,
        ]);

        return Inertia::render('pages/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Ürün ana bilgileri
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',

            // Ürün resimleri (array ve her biri zorunlu) - ARTIK SADECE PATH OLARAK
            'images' => 'required|array',
            'images.*.main_image' => 'required|string|max:255',
            'images.*.main_image_alt' => 'required|string|max:255',
            'images.*.hover_image' => 'nullable|string|max:255',
            'images.*.hover_image_alt' => 'nullable|string|max:255',

            // Kart resimleri (hala dosya yükleniyor)
            'card_image.main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'card_image.secondary_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'card_image.main_image_alt' => 'required|string|max:255',
            'card_image.secondary_image_alt' => 'required|string|max:255',
            'card_image.title' => 'required|string|max:255',
            'card_image.description' => 'required|string',

            // Ürün renkleri (id dizisi)
            'colors' => 'nullable|array',
            'colors.*' => 'nullable|exists:colors,id',

            // Ürün attributeleri (array)
            'attributes' => 'required|array',
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.value' => 'required|string|max:255',

            // SEO bilgileri
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
            'canonical_url' => 'required|string|max:255',
        ]);


        $category = Category::find($validated['category_id']);
        $categorySlug = $category ? $category->slug : 'kategori';

        $canonicalUrl = '/kategori/' . $categorySlug . '/' . ltrim($validated['slug'], '/');

        // Sadece ana ürün bilgisini kaydet
        $product = Product::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'],
            'canonical_url' => $canonicalUrl,
        ]);

        collect($validated['attributes'])->each(
            fn($attr) => $product->attributes()->create([
                'name' => $attr['name'],
                'value' => $attr['value'],
            ]),
        );

        $card = $validated['card_image'];
        $mainImageName = Str::slug($card['title'], '-', 'tr') . '-' . uniqid('main_') . '.' . $card['main_image']->getClientOriginalExtension();
        $secondaryImageName = Str::slug($card['title'], '-', 'tr') . '-' . uniqid('secondary_') . '.' . $card['secondary_image']->getClientOriginalExtension();

        $lastSortOrder = $product->cardImages()->max('sort_order') ?? 0;

        $product->cardImages()->create([
            'main_image' => $card['main_image']->storeAs('products/card_images', $mainImageName, 'public'),
            'secondary_image' => $card['secondary_image']->storeAs('products/card_images', $secondaryImageName, 'public'),
            'main_image_alt' => $card['main_image_alt'],
            'secondary_image_alt' => $card['secondary_image_alt'],
            'title' => $card['title'],
            'description' => $card['description'],
            'sort_order' => $lastSortOrder + 1, // Otomatik olarak bir sonraki sırayı ata
        ]);

        // Resim kaydetme işlemi - URL'den path'e çevir
        collect($validated['images'])->each(function ($image) use ($product) {
            $mainImagePath = $image['main_image'];
            $hoverImagePath = $image['hover_image'] ?? null;

            $product->images()->create([
                'main_image' => $mainImagePath,
                'hover_image' => $hoverImagePath,
                'main_image_alt' => $image['main_image_alt'],
                'hover_image_alt' => $image['hover_image_alt'] ?? '',
            ]);
        });

        $product->colors()->sync($validated['colors'] ?? []);

        return redirect()->back()->with('success', 'Ürün başarıyla oluşturuldu!');
    }

    public function destroy($id)
    {
        // Silme işlemi
    }

    public function show($id)
    {
        $product = Product::with([
            'category',
            'images' => function ($query) {
                $query->orderBy('id')->limit(3);
            },
            'cardImages',
            'colors',
            'attributes'
        ])->findOrFail($id);

        $totalImagesCount = Product::find($id)->images()->count();

        return Inertia::render('pages/show', [
            'product' => $product,
            'totalImagesCount' => $totalImagesCount,
            'hasMoreImages' => $totalImagesCount > 3,
        ]);
    }

    // Yeni method: Daha fazla resim getir
    public function loadMoreImages(Request $request, $id)
    {
        $offset = $request->get('offset', 3);
        $limit = $request->get('limit', 6);

        $images = Product::find($id)
            ->images()
            ->orderBy('id')
            ->skip($offset)
            ->take($limit)
            ->get();

        $totalCount = Product::find($id)->images()->count();
        $hasMore = ($offset + $limit) < $totalCount;

        return response()->json([
            'images' => $images,
            'hasMore' => $hasMore,
            'totalCount' => $totalCount,
        ]);
    }

    /**
     * Dosya yükleme işlemini yapan yardımcı fonksiyon.
     * Orijinal dosya adını Türkçe karakterlerden arındırır ve kaydeder.
     * SADECE PATH DÖNDÜRÜR, TAM URL DEĞİL!
     */
    public function uploadImageFile(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'Dosya bulunamadı.'], 400);
        }

        $file = $request->file('file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        // Türkçe karakterleri temizle
        $cleanName = Str::slug($originalName, '-', 'tr');
        $fileName = $cleanName . '.' . $extension;

        // Dosyayı kaydet
        $path = $file->storeAs('products/images', $fileName, 'public');

        return response()->json([
            'success' => true,
            'message' => 'Dosya başarıyla yüklendi.',
            'file_path' => $path, // SADECE PATH
            'file_url' => asset('storage/' . $path), // FRONTEND İÇİN PREVIEW URL
        ]);
    }
}
