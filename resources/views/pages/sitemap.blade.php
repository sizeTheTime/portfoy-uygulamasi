@extends('layouts.app')

@section('title', 'Site Haritası')
@section('description', 'Mikrofon süngeri ile ilgili tüm sayfaların listelendiği site haritası.')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
        <div class="container mx-auto px-4 py-12">
            <!-- Main Content -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <!-- Main Pages Sidebar -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 sticky top-8">
                        <div class="flex items-center mb-6">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Ana Sayfalar</h2>
                        </div>

                        <nav class="space-y-3">
                            <a href="{{ route('anasayfa') }}"
                                class="group flex items-center p-4 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center mr-4 transition-colors duration-300">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-700">Ana Sayfa</h3>
                                    <p class="text-sm text-gray-500">Tüm kategoriler ve ürünler</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>

                            <a href="{{ route('iletisim') }}"
                                class="group flex items-center p-4 rounded-xl hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-green-100 group-hover:bg-green-200 rounded-lg flex items-center justify-center mr-4 transition-colors duration-300">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-green-700">İletişim</h3>
                                    <p class="text-sm text-gray-500">Bizimle iletişime geçin</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>

                            <a href="{{ route('kurumsal') }}"
                                class="group flex items-center p-4 rounded-xl hover:bg-gradient-to-r hover:from-purple-50 hover:to-purple-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-purple-100 group-hover:bg-purple-200 rounded-lg flex items-center justify-center mr-4 transition-colors duration-300">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-purple-700">Kurumsal</h3>
                                    <p class="text-sm text-gray-500">Hakkımızda bilgiler</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>

                            <a href="{{ route('blog') }}"
                                class="group flex items-center p-4 rounded-xl hover:bg-gradient-to-r hover:from-pink-50 hover:to-pink-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-pink-100 group-hover:bg-pink-200 rounded-lg flex items-center justify-center mr-4 transition-colors duration-300">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-pink-700">Blog</h3>
                                    <p class="text-sm text-gray-500">Güncel yazılar ve haberler</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-600 group-hover:translate-x-1 transition-all duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Categories & Products & Blogs -->
                <div class="xl:col-span-3 space-y-8">
                    <!-- Categories & Products Section -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <div class="flex items-center mb-8">
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900">Kategoriler ve Ürünler</h2>
                        </div>

                        @if ($categories && count($categories) > 0)
                            <div class="space-y-10">
                                @foreach ($categories as $category)
                                    <div
                                        class="border-l-4 border-gradient-to-b md:pl-6 bg-gradient-to-r from-gray-50 to-white rounded-r-2xl md:p-6">
                                        <!-- Category Header -->
                                        <div class="mb-4">
                                            <a href="{{ route('category.show', $category->slug) }}"
                                                class="group inline-flex items-center hover:bg-white hover:shadow-md rounded-xl p-3 transition-all duration-300 w-full">
                                                <div
                                                    class="w-16 h-16 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $category->image->image_path) }}"
                                                        alt="{{ $category->image->image_path }}"
                                                        class="w-16 h-16 object-cover rounded-xl" />
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h3
                                                        class="text-lg font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-300 truncate">
                                                        {{ $category->name }}
                                                    </h3>
                                                    @if ($category->description)
                                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                                            {{ $category->description }}</p>
                                                    @endif
                                                    <div class="flex items-center mt-2">
                                                        <span
                                                            class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full font-medium">
                                                            {{ $category->products->count() }} ürün
                                                        </span>
                                                    </div>
                                                </div>
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300 flex-shrink-0"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                        <!-- Products Grid -->
                                        @if ($category->products && count($category->products) > 0)
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                                @foreach ($category->products as $product)
                                                    <a href="{{ route('product.show', ['category_slug' => $category->slug, 'product_slug' => $product->slug]) }}"
                                                        class="group bg-white hover:bg-gray-50 rounded-xl p-4 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">

                                                        <!-- Product Image -->
                                                        <div class="flex items-center mb-3">
                                                            @if (isset($product->cardImage->main_image))
                                                                <img src="{{ asset('storage/' . $product->cardImage->main_image) }}"
                                                                    alt="{{ $product->name }}"
                                                                    class="w-16 h-16 object-cover rounded-xl mr-4 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                                            @else
                                                                <div
                                                                    class="w-16 h-16 bg-gradient-to-r from-gray-200 to-gray-300 rounded-xl mr-4 flex-shrink-0 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                                                    <svg class="w-8 h-8 text-gray-400" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            @endif

                                                            <!-- Product Info -->
                                                            <div class="flex-1 min-w-0">
                                                                <h4
                                                                    class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-300 truncate text-lg">
                                                                    {{ $product->name }}
                                                                </h4>
                                                                @if ($product->description)
                                                                    <p class="text-sm text-gray-500 truncate mt-1">
                                                                        {{ Str::limit($product->description, 60) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <!-- Product Footer -->
                                                        <div
                                                            class="flex items-center justify-between pt-3 border-t border-gray-100">
                                                            <span class="text-xs text-gray-500">Detayları gör</span>
                                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center py-8 bg-gray-50 rounded-xl">
                                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-4 4m0 0l-4-4m4 4V3">
                                                    </path>
                                                </svg>
                                                <p class="text-gray-500 font-medium">Bu kategoride henüz ürün bulunmuyor
                                                </p>
                                                <p class="text-sm text-gray-400">Yakında yeni ürünler eklenecek.</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-16">
                                <div
                                    class="w-24 h-24 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Henüz kategori bulunmuyor</h3>
                                <p class="text-gray-500 text-lg">Yakında yeni kategoriler ve ürünler eklenecek.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Blog Posts Section -->
                    @if ($blogs && count($blogs) > 0)
                        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                            <div class="flex items-center mb-8">
                                <div
                                    class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h2 class="text-3xl font-bold text-gray-900">Blog Yazıları</h2>
                                    <p class="text-gray-600 mt-1">{{ count($blogs) }} yazı bulundu</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($blogs as $blog)
                                    <!--Rota-->
                                    <a href=""
                                        class="group bg-gradient-to-r from-gray-50 to-white hover:from-white hover:to-gray-50 rounded-xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100">

                                        <!-- Blog Image -->
                                        <div class="mb-4">
                                            @if ($blog->featured_image)
                                                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                                    alt="{{ $blog->title }}"
                                                    class="w-full h-32 object-cover rounded-lg group-hover:scale-105 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-32 bg-gradient-to-r from-orange-200 to-red-300 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                                    <svg class="w-12 h-12 text-orange-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Blog Content -->
                                        <div class="flex-1">
                                            <h3
                                                class="text-lg font-bold text-gray-900 group-hover:text-orange-700 transition-colors duration-300 mb-2 line-clamp-2">
                                                {{ $blog->title }}
                                            </h3>

                                            @if ($blog->excerpt)
                                                <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                                    {{ Str::limit($blog->excerpt, 100) }}
                                                </p>
                                            @endif

                                            <!-- Blog Meta -->
                                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                                <div class="flex items-center text-xs text-gray-500">
                                                    {{ $blog->published_at }}
                                                </div>
                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all duration-300"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <!-- View All Blogs Link -->
                            <div class="text-center mt-8">
                                <a href="{{ route('blog') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                    Tüm Blog Yazılarını Gör
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
