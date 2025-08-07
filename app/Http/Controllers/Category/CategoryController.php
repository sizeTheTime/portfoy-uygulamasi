<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryImage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    // Kategori listeleme (resimleriyle birlikte)
    public function index()
    {
        $categories = Category::with('images')->latest()->get();
        return Inertia::render('categories/index', [
            'categories' => $categories,
        ]);
    }

    // Kategori oluşturma formu (ayrı sayfa)
    public function create()
    {
        return Inertia::render('categories/create');
    }

    // Kategori ve resmi birlikte kaydetme
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'required|string',
            'short_description' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
            'image_file' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'alt_text' => 'required|string|max:255',
            'title' => 'required|string|max:255',
        ]);

        // canonical_url bilgisini Türkçe kategori yoluna göre ayarla
        $validated['canonical_url'] = url('/kategori/' . $validated['slug']);

        // Görseli yükle
        $imagePath = $request->file('image_file')->store('kategori', 'public');

        $category = Category::create($validated);

        CategoryImage::create([
            'category_id' => $category->id,
            'image_path' => $imagePath,
            'alt_text' => $validated['alt_text'],
            'title' => $validated['title'],
        ]);

        return back()->with('status', 'Kategori ve resmi başarıyla oluşturuldu.');
    }

    // Kategori silme (resimleriyle birlikte)
    public function destroy($id)
    {
        $category = Category::with('images')->findOrFail($id);

        // İlgili resimleri sil
        foreach ($category->images as $image) {
            $image->delete();
        }

        $category->delete();

        return redirect()->route('categories')->with('status', 'Kategori ve resimleri silindi.');
    }
}
