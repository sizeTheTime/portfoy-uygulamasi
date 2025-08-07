<?php

namespace App\Http\Controllers\Product\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;

class ProductColorController extends Controller
{
    // Renk düzenleme sayfası: olanlar ve olmayanlar ayrı gruplar
    public function edit($id)
    {
        $product = Product::with('colors')->findOrFail($id);

        $usedColors = $product->colors;
        $usedColorIds = $usedColors->pluck('id')->toArray();

        $unusedColors = Color::whereNotIn('id', $usedColorIds)->get();

        return inertia('pages/edit/edit-product-colors', [
            'product_id' => $product->id,
            'usedColors' => $usedColors, // Üründe olan renkler
            'unusedColors' => $unusedColors, // Üründe olmayan renkler
        ]);
    }

    // Renk ekle (tekil)
    public function addColor(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
        ]);

        if (!$product->colors->contains($validated['color_id'])) {
            $product->colors()->attach($validated['color_id']);
        }

        return redirect()->back()->with('success', 'Renk başarıyla eklendi!');
    }

    // Renk sil (tekil)
    public function removeColor(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'color_id' => 'required|exists:colors,id',
        ]);

        $product->colors()->detach($validated['color_id']);

        return redirect()->back()->with('success', 'Renk başarıyla kaldırıldı!');
    }
}
