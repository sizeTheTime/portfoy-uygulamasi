{{-- filepath: resources/views/pages/home.blade.php --}}
@extends('layouts.app')
@section('title', 'Logo Baskılı Mikrofon Süngeri | Bi mikrofon Süngeri')
@section('meta_description',
    'Logo baskılı mikrofon süngeri; silindir, kare, üçgen gibi özel şekillerde ₺900 fiyatla.
    Hızlı üretim, profesyonel baskı.')



@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[calc(100vh-100px)] overflow-hidden" x-data="{
        selectedImage: '{{ isset($categories[0]->products[0]->cardImage->main_image) ? asset('storage/' . $categories[0]->products[0]->cardImage->main_image) : '' }}',
        currentImage: '{{ isset($categories[0]->products[0]->cardImage->main_image) ? asset('storage/' . $categories[0]->products[0]->cardImage->main_image) : '' }}',
        isTransitioning: false,
        defaultImage: '{{ isset($categories[0]->products[0]->cardImage->main_image) ? asset('storage/' . $categories[0]->products[0]->cardImage->main_image) : '' }}',
        isMobile: window.innerWidth < 1024,
    
        changeImage(newImage) {
            if (!this.isMobile && this.currentImage !== newImage) {
                this.isTransitioning = true;
                setTimeout(() => {
                    this.currentImage = newImage;
                    setTimeout(() => {
                        this.isTransitioning = false;
                    }, 50);
                }, 200);
            }
        },
    
        resetToSelected() {
            if (!this.isMobile) {
                this.changeImage(this.selectedImage);
            }
        },
    
        selectImage(newImage) {
            this.selectedImage = newImage;
            this.changeImage(newImage);
        }
    }"
        x-init="window.addEventListener('resize', () => {
            isMobile = window.innerWidth < 1024;
        });">


        <x-left-content>
            <div class="bg-white rounded-2xl shadow-lg p-0 sm:p-6 lg:p-8 border border-gray-100">
                @if ($categories && count($categories) > 0)
                    <div class="space-y-6 lg:space-y-10">
                        @foreach ($categories as $category)
                            <div
                                class="border-none md:border-l-4 border-gradient-to-b pl-3 sm:pl-4 lg:pl-6 bg-gradient-to-r from-gray-50 to-white rounded-r-2xl p-3 sm:p-4 lg:p-6">
                                <!-- Category Header -->
                                <div class="mb-4 lg:mb-6 border border-gray-200 rounded-lg">
                                    <a href="{{ route('category.show', $category->slug) }}"
                                        class="group inline-flex items-center hover:bg-white hover:shadow-md rounded-xl p-2 sm:p-3 lg:p-4 transition-all duration-300 w-full"
                                        @mouseenter="changeImage('{{ isset($category->image->image_path) ? asset('storage/' . $category->image->image_path) : '' }}')"
                                        @mouseleave="resetToSelected()">
                                        <div
                                            class="w-16 h-16 sm:w-20 sm:h-20 lg:w-32 lg:h-32 rounded-xl lg:rounded-2xl flex items-center justify-center mr-3 lg:mr-4 group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                            <img src="{{ asset('storage/' . $category->image->image_path) }}"
                                                alt="{{ $category->image->image_path }}"
                                                class="w-full h-full object-cover rounded-xl lg:rounded-2xl" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-300 truncate">
                                                {{ $category->name }}
                                            </h3>
                                            @if ($category->description)
                                                <p class="text-sm lg:text-base text-gray-600 mt-1 line-clamp-2">
                                                    {{ $category->description }}</p>
                                            @endif
                                            <div class="flex items-center mt-2">
                                                <span
                                                    class="px-2 py-1 text-xs lg:text-sm bg-blue-100 text-blue-800 rounded-full font-medium">
                                                    {{ $category->products->count() }} ürün
                                                </span>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-2 transition-all duration-300 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                            </path>
                                        </svg>
                                    </a>
                                </div>

                                <!-- Products Grid -->
                                @if ($category->products && count($category->products) > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3 lg:gap-4">
                                        @foreach ($category->products as $product)
                                            <a href="{{ route('product.show', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}"
                                                class="group bg-white hover:bg-gray-50 rounded-xl p-3 lg:p-4 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100"
                                                @mouseenter="selectImage('{{ isset($product->cardImage->main_image) ? asset('storage/' . $product->cardImage->main_image) : '' }}')"
                                                {{-- @mouseleave="resetToSelected()" kaldırıldı --}}>

                                                <!-- Product Image -->
                                                <div class="flex items-start mb-3">
                                                    @if (isset($product->cardImage->main_image))
                                                        <img src="{{ asset('storage/' . $product->cardImage->main_image) }}"
                                                            alt="{{ $product->name }}"
                                                            class="w-16 h-16 sm:w-20 sm:h-20 lg:w-28 lg:h-28 object-cover rounded-lg lg:rounded-xl mr-3 lg:mr-4 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                                    @else
                                                        <div
                                                            class="w-16 h-16 sm:w-20 sm:h-20 lg:w-28 lg:h-28 bg-gradient-to-r from-gray-200 to-gray-300 rounded-lg lg:rounded-xl mr-3 lg:mr-4 flex-shrink-0 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @endif

                                                    <!-- Product Info -->
                                                    <div class="flex-1 min-w-0">
                                                        <h4
                                                            class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300 text-sm sm:text-base lg:text-lg line-clamp-2">
                                                            {{ $product->name }}
                                                        </h4>
                                                        @if ($product->description)
                                                            <p
                                                                class="text-xs sm:text-sm text-gray-500 mt-1 line-clamp-2 lg:line-clamp-3">
                                                                {{ Str::limit($product->description, 80) }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Product Footer -->
                                                <div
                                                    class="flex items-center justify-between pt-2 lg:pt-3 border-t border-gray-100">
                                                    <span class="text-xs text-gray-500">Detayları gör</span>
                                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-6 lg:py-8 bg-gray-50 rounded-xl">
                                        <svg class="w-8 h-8 lg:w-12 lg:h-12 text-gray-400 mx-auto mb-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-4 4m0 0l-4-4m4 4V3">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 font-medium text-sm lg:text-base">Bu kategoride henüz ürün
                                            bulunmuyor</p>
                                        <p class="text-xs lg:text-sm text-gray-400">Yakında yeni ürünler eklenecek.</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12 lg:py-16">
                        <div
                            class="w-16 h-16 lg:w-24 lg:h-24 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-4 lg:mb-6">
                            <svg class="w-8 h-8 lg:w-12 lg:h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Henüz kategori bulunmuyor</h3>
                        <p class="text-gray-500 text-base lg:text-lg">Yakında yeni kategoriler ve ürünler eklenecek.</p>
                    </div>
                @endif
            </div>

        </x-left-content>

        <x-right-content>
            <x-product-image-display :current-image="'currentImage'" :is-transitioning="'isTransitioning'" />
        </x-right-content>
    </div>
@endsection
