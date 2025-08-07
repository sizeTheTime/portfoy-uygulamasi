<?php

namespace App\Http\Controllers\Product\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductInformationController extends Controller
{
    // Ürün temel bilgilerini düzenleme formu
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return inertia('pages/edit/edit-product-information', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    // Ürün temel bilgilerini güncelle
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            // SEO alanları
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
        ]);

        $product->update($validated);

        return redirect()->back()->with('success', 'Ürün ve SEO bilgileri başarıyla güncellendi.');
    }
}
