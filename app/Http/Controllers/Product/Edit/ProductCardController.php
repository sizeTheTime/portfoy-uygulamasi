<?php

namespace App\Http\Controllers\Product\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductCardController extends Controller
{
    // Kart bilgilerini düzenleme sayfası
    public function edit($id)
    {
        $product = Product::with('cardImages')->findOrFail($id);

        // Sadece ilk kart bilgisini gönder (tek kart varsa)
        $card = $product->cardImages->first();

        // Resim yollarını tam url'ye çevir
        if ($card) {
            $card->main_image = $card->main_image ? Storage::url($card->main_image) : null;
            $card->secondary_image = $card->secondary_image ? Storage::url($card->secondary_image) : null;
        }

        return inertia('pages/edit/edit-product-card', [
            'card' => $card,
            'product_id' => $product->id,
        ]);
    }

    // Kart bilgisi düzenle (sadece updateCard)
    public function updateCard(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'main_image' => 'nullable|file|image|max:2048',
            'secondary_image' => 'nullable|file|image|max:2048',
            'main_image_alt' => 'nullable|string|max:255',
            'secondary_image_alt' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $card = $product->cardImage;
        if (!$card) {
            // Eğer kart yoksa, oluştur
            $card = $product->cardImage()->create([]);
        }

        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('products/card_images', 'public');
            $card->main_image = $mainImagePath;
        }
        if ($request->hasFile('secondary_image')) {
            $secondaryImagePath = $request->file('secondary_image')->store('products/card_images', 'public');
            $card->secondary_image = $secondaryImagePath;
        }

        $card->main_image_alt = $request->input('main_image_alt');
        $card->secondary_image_alt = $request->input('secondary_image_alt');
        $card->title = $request->input('title');
        $card->description = $request->input('description');
        $card->save();

        return redirect()->back()->with('success', 'Kart bilgisi başarıyla güncellendi!');
    }
}
