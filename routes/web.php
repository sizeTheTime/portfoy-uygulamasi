<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Color\ColorController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\Edit\ProductInformationController;
use App\Http\Controllers\Product\Edit\ProductColorController;
use App\Http\Controllers\Product\Edit\ProductGalleryController;
use App\Http\Controllers\Product\Edit\ProductAttributeController;
use App\Http\Controllers\Product\Edit\ProductCardController;
use App\Http\Controllers\Blog\BlogController;



Route::get('/', [HomeController::class, 'index'])->name('anasayfa');

// İletişim
Route::get('/iletisim', fn() => view('pages.contact'))->name('iletisim');

// Kurumsal
Route::get('/kurumsal', fn() => view('pages.kurumsal'))->name('kurumsal');

// Sitemap
Route::get('/sitemap', [HomeController::class, 'sitemap'])->name('sitemap');

// Blog → Anasayfa’ya yönlendir ve mesaj gösterme örnek
Route::get('/yazilarimiz', [HomeController::class, 'blogs'])->name('blog');
Route::get('/yazilarimiz/{slug}', [HomeController::class, 'blog'])->name('web.blogs.show');

Route::get('/kategori/{category_slug}/{product_slug}', [HomeController::class, 'showProduct'])->name('product.show');
Route::get('/kategori/{category_slug}', [HomeController::class, 'showCategory'])->name('category.show');
Route::get('/products/{product_slug}/load-more-images', [HomeController::class, 'loadMoreImages']);




Route::get('/panel', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard altında alt sayfalar
Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->group(function () {

        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Product (pages) rotaları
        Route::prefix('pages')
            ->name('pages.')
            ->group(function () {
                Route::get('', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('', [ProductController::class, 'store'])->name('store');
                Route::get('/{id}', [ProductController::class, 'show'])->name('show');
                Route::get('/{id}/load-more-images', [ProductController::class, 'loadMoreImages'])->name('load-more-images');
            });

        Route::get('colors', [ColorController::class, 'index'])->name('colors');
        Route::get('colors/create', [ColorController::class, 'create'])->name('colors.create');
        Route::post('colors', [ColorController::class, 'store'])->name('colors.store');
        Route::delete('colors/{color}', [ColorController::class, 'destroy'])->name('colors.destroy');

        // Blog rotaları


        Route::get('posts', function () {
            return Inertia::render('posts/index');
        })->name('posts');

        Route::get('statistics', function () {
            return Inertia::render('statistics/index');
        })->name('statistics');

        // Ürün düzenleme (edit) rotaları
        Route::prefix('pages/{id}/edit')->name('pages.edit.')->group(function () {
            // Temel bilgiler
            Route::get('information', [ProductInformationController::class, 'edit'])->name('information');
            Route::post('information', [ProductInformationController::class, 'update']);

            // Renkler
            Route::get('colors', [ProductColorController::class, 'edit'])->name('colors');
            Route::post('colors/add', [ProductColorController::class, 'addColor'])->name('colors.add');
            Route::post('colors/remove', [ProductColorController::class, 'removeColor'])->name('colors.remove');

            // Galeri - YENİ ROTALAR
            Route::get('gallery', [ProductGalleryController::class, 'edit'])->name('gallery');

            // Yeni API endpoints
            Route::post('gallery/add-set', [ProductGalleryController::class, 'addImageSet'])->name('gallery.add-set');
            Route::delete('gallery/remove-set/{imageId}', [ProductGalleryController::class, 'removeImageSet'])->name('gallery.remove-set');
            Route::post('gallery/edit-set', [ProductGalleryController::class, 'editImageSet'])->name('gallery.edit-set');

            // Eski rotalar (geriye dönük uyumluluk için kaldırıldı)

            // Özellikler (Attributes)
            Route::get('attributes', [ProductAttributeController::class, 'edit'])->name('attributes');
            Route::post('attributes/add', [ProductAttributeController::class, 'addAttribute'])->name('attributes.add');
            Route::post('attributes/update', [ProductAttributeController::class, 'update'])->name('attributes.update');
            Route::post('attributes/remove', [ProductAttributeController::class, 'removeAttribute'])->name('attributes.remove');

            // Kart Bilgileri
            Route::get('card', [ProductCardController::class, 'edit'])->name('card');
            Route::post('card/add', [ProductCardController::class, 'addCard'])->name('card.add');
            Route::post('card', [ProductCardController::class, 'updateCard'])->name('card.update');
            Route::post('card/remove', [ProductCardController::class, 'removeCard'])->name('card.remove');
        });

        // Blog Management Routes
        Route::prefix('blogs')->name('blogs.')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('index');
            Route::get('/create', [BlogController::class, 'create'])->name('create');
            Route::post('/', [BlogController::class, 'store'])->name('store');
            Route::get('/{blog}', [BlogController::class, 'show'])->name('show');
            Route::get('/{blog}/edit', [BlogController::class, 'edit'])->name('edit');
            Route::put('/{blog}', [BlogController::class, 'update'])->name('update');
            Route::delete('/{blog}', [BlogController::class, 'destroy'])->name('destroy');


            Route::get('/{blog}/update-image', [BlogController::class, 'editImage'])->name('edit-image');

            Route::post('/{blog}/update-image', [BlogController::class, 'updateImage'])->name('update-image');
        });
    });



Route::post('dashboard/pages/upload-image', [ProductController::class, 'uploadImageFile'])->name('pages.upload-image');
Route::post('/blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload-image');
Route::post('/blogs/delete-image', [BlogController::class, 'deleteImage'])->name('blogs.delete-image');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
