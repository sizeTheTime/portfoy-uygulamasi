<?php

namespace App\Http\Controllers\Product\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductGalleryController extends Controller
{
    /**
     * Galeri düzenleme sayfasını gösterir.
     */
    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id);

        $images = $product->images->map(function ($image) {
            return [
                'id' => $image->id,
                'main_image' => $image->main_image,
                'main_image_alt' => $image->main_image_alt,
                'hover_image' => $image->hover_image,
                'hover_image_alt' => $image->hover_image_alt,
            ];
        });

        return inertia('pages/edit/edit-product-gallery', [
            'product_id' => $product->id,
            'images' => $images,
        ]);
    }

    /**
     * Yeni resim seti ekler (modal ile tüm bilgiler birlikte)
     */
    public function addImageSet(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'main_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'main_image_alt' => 'required|string|max:255',
            'hover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hover_image_alt' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Ana resmi kaydet
            $mainFile = $request->file('main_image');
            $mainFileName = $this->generateFileName($mainFile, 'main');
            $mainPath = $mainFile->storeAs('products/images', $mainFileName, 'public');

            // Hover resmi varsa kaydet
            $hoverPath = null;
            if ($request->hasFile('hover_image')) {
                $hoverFile = $request->file('hover_image');
                $hoverFileName = $this->generateFileName($hoverFile, 'hover');
                $hoverPath = $hoverFile->storeAs('products/images', $hoverFileName, 'public');
            }

            // Veritabanına kaydet
            $newImage = $product->images()->create([
                'main_image' => $mainPath,
                'main_image_alt' => $validated['main_image_alt'],
                'hover_image' => $hoverPath,
                'hover_image_alt' => $validated['hover_image_alt'] ?? '',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Resim seti başarıyla eklendi',
                'image' => [
                    'id' => $newImage->id,
                    'main_image' => $newImage->main_image,
                    'main_image_alt' => $newImage->main_image_alt,
                    'hover_image' => $newImage->hover_image,
                    'hover_image_alt' => $newImage->hover_image_alt,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Resim seti eklenirken hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tüm resim setini siler (main + hover + alt textler)
     */
    public function removeImageSet($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->findOrFail($imageId);

        try {
            // Tüm dosyaları sil
            if ($image->main_image) {
                Storage::disk('public')->delete($image->main_image);
            }
            if ($image->hover_image) {
                Storage::disk('public')->delete($image->hover_image);
            }

            // Veritabanından sil
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Resim seti tamamen silindi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Resim seti silinirken hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resim setini düzenler (modal ile - resim ve/veya alt text)
     */
    public function editImageSet(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'image_id' => 'required|exists:product_images,id',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'main_image_alt' => 'nullable|string|max:255',
            'hover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'hover_image_alt' => 'nullable|string|max:255',
            'remove_hover_image' => 'nullable|boolean', // Hover resmi kaldırma flag'i
        ]);

        try {
            DB::beginTransaction();

            $image = $product->images()->findOrFail($validated['image_id']);
            $updateData = [];

            // Ana resim güncelleme
            if ($request->hasFile('main_image')) {
                // Eski ana resmi sil
                if ($image->main_image) {
                    Storage::disk('public')->delete($image->main_image);
                }

                // Yeni ana resmi kaydet
                $mainFile = $request->file('main_image');
                $mainFileName = $this->generateFileName($mainFile, 'main');
                $updateData['main_image'] = $mainFile->storeAs('products/images', $mainFileName, 'public');
            }

            // Ana resim alt text güncelleme
            if ($request->has('main_image_alt')) {
                $updateData['main_image_alt'] = $validated['main_image_alt'] ?? '';
            }

            // Hover resmi kaldırma
            if ($request->boolean('remove_hover_image')) {
                if ($image->hover_image) {
                    Storage::disk('public')->delete($image->hover_image);
                }
                $updateData['hover_image'] = null;
                $updateData['hover_image_alt'] = '';
            }
            // Hover resim güncelleme
            elseif ($request->hasFile('hover_image')) {
                // Eski hover resmi sil
                if ($image->hover_image) {
                    Storage::disk('public')->delete($image->hover_image);
                }

                // Yeni hover resmi kaydet
                $hoverFile = $request->file('hover_image');
                $hoverFileName = $this->generateFileName($hoverFile, 'hover');
                $updateData['hover_image'] = $hoverFile->storeAs('products/images', $hoverFileName, 'public');
            }

            // Hover resim alt text güncelleme
            if ($request->has('hover_image_alt') && !$request->boolean('remove_hover_image')) {
                $updateData['hover_image_alt'] = $validated['hover_image_alt'] ?? '';
            }

            // Veritabanını güncelle
            $image->update($updateData);

            // Güncellenmiş resim bilgilerini yeniden yükle
            $image->refresh();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Resim seti başarıyla güncellendi',
                'image' => [
                    'id' => $image->id,
                    'main_image' => $image->main_image,
                    'main_image_alt' => $image->main_image_alt,
                    'hover_image' => $image->hover_image,
                    'hover_image_alt' => $image->hover_image_alt,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Resim seti güncellenirken hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dosya adı oluşturan yardımcı fonksiyon
     */
    private function generateFileName($file, $type)
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $cleanName = Str::slug($originalName, '-', 'tr');
        return $cleanName . '_' . $type . '_' . uniqid() . '.' . $extension;
    }
}
