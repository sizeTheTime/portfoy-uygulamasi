{{-- filepath: resources/views/pages/blogs/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Bi Mikrofon süngeri Yazılarımız')
@section('description', 'Mikrofon süngeri ile ilgili rehber yazılar, fiyat güncellemeleri ve uzman tavsiyeleri.')

@if(isset($structuredData))
@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush
@endif

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Mikrofon Süngeri Blog
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ses kalitesinden marka tanıtımına, mikrofon süngeri dünyasının her detayını keşfedin.
            </p>
            
            @if(isset($blogs) && $blogs->count() > 0)
                <div class="mt-6 text-sm text-gray-500">
                    {{ $blogs->count() }} yazı • Güncel içerik • Uzman tavsiyeleri
                </div>
            @endif
        </div>

        @if(isset($blogs) && $blogs->count() > 0)
            
            <div class="mb-12">
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:w-2/3 p-8">
                            <div class="text-xs text-blue-600 font-semibold uppercase tracking-wide mb-2">
                                Öne Çıkan
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">
                                {{ $blogs->first()->title }}
                            </h2>
                            <p class="text-gray-600 mb-6">
                                {{ $blogs->first()->excerpt }}
                            </p>
                            <a href="{{ route('web.blogs.show', $blogs->first()->slug) }}"
                                class="inline-flex items-center text-blue-600 font-medium hover:text-blue-800">
                                Yazıyı oku
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="md:w-1/3">
                            @if($blogs->first()->featured_image)
                                <img src="{{ asset('storage/' . $blogs->first()->featured_image) }}" 
                                     alt="{{ $blogs->first()->title }}"
                                     class="w-full h-48 md:h-full object-cover">
                            @else
                                <div class="w-full h-48 md:h-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Tüm Yazılar</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($blogs as $blog)
                        <article class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                            @if($blog->featured_image)
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                     alt="{{ $blog->title }}"
                                     class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    @if (mb_strlen($blog->title) > 60)
                                        {{ mb_substr($blog->title, 0, 60) . '...' }}
                                    @else
                                        {{ $blog->title }}
                                    @endif
                                </h3>
                                
                                <p class="text-gray-600 text-sm mb-4">
                                    @if ($blog->excerpt && mb_strlen($blog->excerpt) > 120)
                                        {{ mb_substr($blog->excerpt, 0, 120) . '...' }}
                                    @else
                                        {{ $blog->excerpt ?? 'Bu yazı hakkında detayları keşfedin.' }}
                                    @endif
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">
                                        {{ rand(3, 8) }} dk okuma
                                    </span>
                                    <a href="{{ route('web.blogs.show', $blog->slug) }}"
                                        class="text-blue-600 text-sm font-medium hover:text-blue-800">
                                        Devamını oku
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @else
            
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">
                        Henüz Blog Yazısı Yok
                    </h2>
                    
                    <p class="text-gray-600 mb-8">
                        Mikrofon süngeri rehberleri yakında yayınlanacak. 
                        Güncellemeler için bizi takip edin.
                    </p>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Yakında:</h3>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>• Mikrofon Süngeri Seçim Rehberi</li>
                            <li>• Ses Kalitesi İyileştirme İpuçları</li>
                            <li>• Marka Karşılaştırmaları</li>
                            <li>• Fiyat Analizi ve Öneriler</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-12 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
                <h2 class="text-xl font-bold text-gray-900 mb-3">
                    @if(isset($blogs) && $blogs->count() > 0)
                        Blog Güncellemelerini Kaçırmayın
                    @else
                        İlk Yazılarımızdan Haberdar Olun
                    @endif
                </h2>
                <p class="text-gray-600 mb-4">
                    @if(isset($blogs) && $blogs->count() > 0)
                        Yeni rehberler ve uzman tavsiyeleri için e-posta listemize katılın.
                    @else
                        Mikrofon süngeri rehberleri yayınlandığında ilk siz haberdar olun.
                    @endif
                </p>
            </div>
        </div>

        <div class="text-center">
            <div class="bg-white border border-gray-200 rounded-lg p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-3">
                    Mikrofon Süngeri Konusunda Yardım
                </h2>
                <p class="text-gray-600 mb-6">
                    @if(isset($blogs) && $blogs->count() > 0)
                        Blog yazılarımızda bulamadığınız sorular için
                    @else
                        Mikrofon süngeri seçimi konusundaki tüm sorularınız için
                    @endif
                    uzman ekibimizle iletişime geçin.
                </p>
                <x-contact-buttons />
            </div>
        </div>
    </div>
@endsection
