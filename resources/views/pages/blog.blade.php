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
    <main class="max-w-6xl mx-auto px-4 py-8">
         Blog Header 
        <header class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-4">
                Mikrofon Süngeri Blog
            </h1>
            <p class="text-base text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Ses kalitesinden marka tanıtımına, üretim sürecinden şehir bazlı hizmetlere kadar mikrofon süngeri
                dünyasının her detayını keşfedin.
            </p>
            
            @if(isset($blogs) && $blogs->count() > 0)
            <div class="mt-8 hidden sm:flex flex-row items-center justify-center space-x-4 text-sm text-gray-500">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    {{ $blogs->count() }} Rehber Yazısı
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Güncel İçerik
                </span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Uzman Tavsiyeleri
                </span>
            </div>
            @endif
        </header>

        @if(isset($blogs) && $blogs->count() > 0)
             Featured Article 
            <section class="mb-12">
                <div class="bg-gradient-to-r from-blue-600 to-blue-900 rounded-2xl p-8 text-white">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <span class="inline-block bg-white bg-opacity-20 text-black text-sm px-3 py-1 rounded-full mb-4">
                                ⭐ Öne Çıkan Yazı
                            </span>
                            <h2 class="text-3xl font-bold mb-4">
                                {{ $blogs->first()->title }}
                            </h2>
                            <p class="text-blue-100 mb-6 leading-relaxed">
                                {{ $blogs->first()->excerpt }}
                            </p>
                            <a href="{{ route('web.blogs.show', $blogs->first()->slug) }}"
                                class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors">
                                Yazıyı Oku
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <div class="hidden md:block">
                            @if($blogs->first()->featured_image)
                                <img src="{{ asset('storage/' . $blogs->first()->featured_image) }}" 
                                     alt="{{ $blogs->first()->title }}"
                                     class="w-full h-64 object-cover rounded-lg shadow-lg">
                            @else
                                <div class="w-full h-64 bg-white bg-opacity-20 rounded-lg shadow-lg flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Blog Kategorileri</h2>
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Genel Bilgiler ve Rehberler</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach ($blogs as $blog)
                    <div class="border rounded-lg p-4 bg-white shadow">
                        @if($blog->featured_image)
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                 alt="{{ $blog->title }}"
                                 class="mb-2 w-full h-44 object-cover rounded">
                        @else
                            <div class="mb-2 w-full h-44 bg-gray-100 rounded flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <h4 class="text-lg min-h-16 font-semibold text-gray-900 mb-2">
                                @if (mb_strlen($blog->title) > 60)
                                    {{ mb_substr($blog->title, 0, 60) . '...' }}
                                @else
                                    {{ $blog->title }}
                                @endif
                            </h4>
                            <p class="text-gray-600 text-sm mb-4">
                                @if ($blog->excerpt && mb_strlen($blog->excerpt) > 160)
                                    {{ mb_substr($blog->excerpt, 0, 160) . '...' }}
                                @else
                                    {{ $blog->excerpt ?? 'Bu yazı için özet bulunmuyor.' }}
                                @endif
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    {{ rand(5, 10) }} dakika okuma
                                </span>
                                <a href="{{ route('web.blogs.show', $blog->slug) }}"
                                    class="text-blue-600 text-sm font-medium hover:underline">
                                    Devamını Oku
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
             Empty State 
            <section class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        Henüz Blog Yazısı Bulunmuyor
                    </h2>
                    <p class="text-gray-600 mb-8">
                        Mikrofon süngeri ile ilgili rehber yazılarımız yakında yayınlanacak. 
                        Güncellemelerden haberdar olmak için bizi takip edin.
                    </p>
                    <div class="space-y-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-900 mb-2">Yakında Gelecek İçerikler:</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Mikrofon Süngeri Seçim Rehberi</li>
                                <li>• Ses Kalitesi İyileştirme İpuçları</li>
                                <li>• Marka Karşılaştırmaları</li>
                                <li>• Fiyat Analizi ve Öneriler</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        @endif

         Newsletter Subscription 
        <section class="mb-12">
            <div class="bg-gradient-to-r from-blue-600 to-blue-900 rounded-2xl p-8 text-white text-center">
                <h2 class="text-2xl font-bold mb-4">
                    @if(isset($blogs) && $blogs->count() > 0)
                        Blog Güncellemelerini Kaçırmayın!
                    @else
                        İlk Blog Yazılarımızdan Haberdar Olun!
                    @endif
                </h2>
                <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                    @if(isset($blogs) && $blogs->count() > 0)
                        Yeni rehberler, fiyat güncellemeleri ve uzman tavsiyeleri için e-posta listemize katılın.
                    @else
                        Mikrofon süngeri rehberleri ve uzman tavsiyeleri yayınlandığında ilk siz haberdar olun.
                    @endif
                </p>
            </div>
        </section>

         Contact CTA 
        <section class="text-center">
            <div class="bg-white rounded-2xl p-8 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Mikrofon Süngeri İhtiyacınız İçin
                </h2>
                <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                    @if(isset($blogs) && $blogs->count() > 0)
                        Blog yazılarımızda bulamadığınız sorularınız için uzman ekibimizle iletişime geçin. 
                    @else
                        Mikrofon süngeri konusundaki tüm sorularınız için uzman ekibimizle iletişime geçin. 
                    @endif
                    Profesyonel danışmanlık ve hızlı çözümler için buradayız.
                </p>
                <div class="flex items-center justify-center">
                    <x-contact-buttons />
                </div>
            </div>
        </section>
    </main>
@endsection
