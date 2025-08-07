<?php

namespace App\Http\Controllers\Product\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;

class ProductAttributeController extends Controller
{
    // Tüm attribute'ları göster
    public function edit($id)
    {
        $product = Product::with('attributes')->findOrFail($id);

        return inertia('pages/edit/edit-product-attributes', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'attributes' => $product->attributes->map(function ($attr) {
                    return [
                        'id' => $attr->id,
                        'name' => $attr->name,
                        'value' => $attr->value,
                    ];
                }),
            ],
        ]);
    }



    // Tüm attribute'ları toplu güncelle (Vue component için ana metod)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'attributes' => 'required|array|min:1',
            'attributes.*.id' => 'nullable|exists:product_attributes,id', // ID eklendi
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.value' => 'required|string|max:255',
        ], [
            'attributes.required' => 'En az bir özellik eklemelisiniz.',
            'attributes.min' => 'En az bir özellik eklemelisiniz.',
            'attributes.*.id.exists' => 'Geçersiz özellik ID\'si.',
            'attributes.*.name.required' => 'Adı mutlaka gereklidir.',
            'attributes.*.name.max' => 'Özellik adı en fazla 255 karakter olabilir.',
            'attributes.*.value.required' => 'Değer mutlaka gereklidir.',
            'attributes.*.value.max' => 'Özellik değeri en fazla 255 karakter olabilir.',
        ]);

        try {
            // Transaction başlat
            DB::beginTransaction();

            // Mevcut attribute ID'lerini topla
            $existingIds = collect($validated['attributes'])
                ->pluck('id')
                ->filter()
                ->toArray();

            // Silinecek attribute'ları bul ve sil
            $product->attributes()
                ->whereNotIn('id', $existingIds)
                ->delete();

            // Her attribute'ı işle
            foreach ($validated['attributes'] as $attributeData) {
                if (!empty($attributeData['id'])) {
                    // Mevcut attribute'ı güncelle
                    $product->attributes()
                        ->where('id', $attributeData['id'])
                        ->update([
                            'name' => trim($attributeData['name']),
                            'value' => trim($attributeData['value']),
                        ]);
                } else {
                    // Yeni attribute oluştur
                    $product->attributes()->create([
                        'name' => trim($attributeData['name']),
                        'value' => trim($attributeData['value']),
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Ürün özellikleri başarıyla güncellendi!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withErrors(['general' => 'Özellikler güncellenirken bir hata oluştu: ' . $e->getMessage()])
                ->withInput();
        }
    }




    // Tekil attribute sil (API için)
    public function removeAttribute(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'attribute_id' => 'required|exists:product_attributes,id',
        ], [
            'attribute_id.required' => 'Attribute id mutlaka gereklidir.',
            'attribute_id.exists' => 'Geçersiz özellik ID\'si.',
        ]);

        try {
            $deleted = $product->attributes()
                ->where('id', $validated['attribute_id'])
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Özellik başarıyla silindi!',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Silinecek özellik bulunamadı.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Özellik silinirken bir hata oluştu.',
            ], 500);
        }
    }
}
