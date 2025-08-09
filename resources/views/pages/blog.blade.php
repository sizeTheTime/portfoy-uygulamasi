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
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 py-12">
            
            <div class="text-center mb-16">
                <div class="inline-flex items-center bg-blue-100 text-blue-800 text-sm font-medium px-4 py-2 rounded-full mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                    Mikrofon Süngeri Blog
                </div>
                
                <h1 class="text-4xl md:text-6xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent mb-6">
                    Ses Dünyasının
                    <span class="block text-blue-600">Rehber Yazıları</span>
                </h1>
                
                <p class="text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed mb-8">
                    Profesyonel ses kalitesinden uzman tavsiyelere, mikrofon süngeri dünyasının 
                    tüm sırlarını keşfedin.
                </p>
                
                @if(isset($blogs) && $blogs->count() > 0)
                    <div class="flex flex-wrap items-center justify-center gap-6 text-sm">
                        <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            {{ $blogs->count() }} Aktif Yazı
                        </div>
                        <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            Uzman İçerikleri
                        </div>
                        <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                            Güncel Rehberler
                        </div>
                    </div>
                @endif
            </div>

            @if(isset($blogs) && $blogs->count() > 0)
                <div class="mb-16">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                        <div class="md:flex">
                            <div class="md:w-1/2 p-8 md:p-12">
                                <div class="inline-flex items-center bg-gradient-to-r from-yellow-400 to-orange-400 text-white text-xs font-bold px-3 py-1 rounded-full mb-4">
                                    ⭐ Editörün Seçimi
                                </div>
                                
                                <h2 class="text-2xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                                    {{ $blogs->first()->title }}
                                </h2>
                                
                                <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                                    {{ $blogs->first()->excerpt }}
                                </p>
                                
                                <a href="{{ route('web.blogs.show', $blogs->first()->slug) }}"
                                    class="group inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    Hemen Oku
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                            
                            <div class="md:w-1/2">
                                @if($blogs->first()->featured_image)
                                    <img src="{{ asset('storage/' . $blogs->first()->featured_image) }}" 
                                         alt="{{ $blogs->first()->title }}"
                                         class="w-full h-64 md:h-full object-cover">
                                @else
                                    <div class="w-full h-64 md:h-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                                        <div class="text-center text-blue-300">
                                            <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                            </svg>
                                            <p class="text-sm font-medium">Mikrofon Süngeri</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-12">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Tüm Rehberler</h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 mx-auto rounded-full"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($blogs as $blog)
                            <article class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group">
                                <div class="relative overflow-hidden">
                                    @if($blog->featured_image)
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                             alt="{{ $blog->title }}"
                                             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4">
                                        <div class="bg-white bg-opacity-90 backdrop-blur-sm text-gray-700 text-xs font-medium px-3 py-1 rounded-full">
                                            {{ rand(3, 8) }} dk okuma
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-blue-600 transition-colors duration-300">
                                        @if (mb_strlen($blog->title) > 55)
                                            {{ mb_substr($blog->title, 0, 55) . '...' }}
                                        @else
                                            {{ $blog->title }}
                                        @endif
                                    </h3>
                                    
                                    <p class="text-gray-600 mb-4 leading-relaxed">
                                        @if ($blog->excerpt && mb_strlen($blog->excerpt) > 120)
                                            {{ mb_substr($blog->excerpt, 0, 120) . '...' }}
                                        @else
                                            {{ $blog->excerpt ?? 'Bu rehber yazısı hakkında detayları keşfedin.' }}
                                        @endif
                                    </p>
                                    
                                    <a href="{{ route('web.blogs.show', $blog->slug) }}"
                                        class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition-colors duration-300 group">
                                        Devamını Oku
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-3xl shadow-xl p-12 text-center">
                        <div class="mb-8">
                            <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full mb-6">
                                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                </svg>
                            </div>
                            
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                                Harika İçerikler Yolda
                            </h2>
                            
                            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                                Mikrofon süngeri dünyasının en kapsamlı rehberleri yakında burada olacak. 
                                Profesyonel tavsiyeleri kaçırmayın.
                            </p>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6 mb-10">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6">
                                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Seçim Rehberleri</h3>
                                <p class="text-gray-600 text-sm">Doğru mikrofon süngeri nasıl seçilir?</p>
                            </div>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6">
                                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Performans İpuçları</h3>
                                <p class="text-gray-600 text-sm">Ses kalitesini maksimuma çıkarın</p>
                            </div>
                            
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6">
                                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Fiyat Analizi</h3>
                                <p class="text-gray-600 text-sm">En uygun fiyatlı seçenekleri keşfedin</p>
                            </div>
                            
                            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6">
                                <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Marka İncelemeleri</h3>
                                <p class="text-gray-600 text-sm">Popüler markaların detaylı analizi</p>
                            </div>
                        </div>
                        
                        <div class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full text-sm font-medium">
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse mr-2"></div>
                            İçerikler hazırlanıyor...
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-16">
                <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 rounded-3xl p-8 md:p-12 text-white text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-10"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center bg-white bg-opacity-20 backdrop-blur-sm text-white text-sm font-medium px-4 py-2 rounded-full mb-6">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Ücretsiz Bülten
                        </div>
                        
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">
                            @if(isset($blogs) && $blogs->count() > 0)
                                Yeni İçeriklerden İlk Siz Haberdar Olun
                            @else
                                İlk Rehberlerimiz Yayınlandığında Haberdar Olun
                            @endif
                        </h2>
                        
                        <p class="text-blue-100 text-lg mb-8 max-w-2xl mx-auto">
                            Mikrofon süngeri dünyasındaki son gelişmeler, uzman tavsiyeleri ve özel indirimler 
                            doğrudan e-posta kutunuza gelsin.
                        </p>
                        
                        <div class="inline-flex items-center bg-white bg-opacity-10 backdrop-blur-sm rounded-full px-6 py-3">
                            <svg class="w-5 h-5 text-yellow-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-sm font-medium">Spam yok, sadece değerli içerik</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        Mikrofon Süngeri Konusunda Yardıma İhtiyacınız Var mı?
                    </h2>
                    
                    <p class="text-gray-600 text-lg mb-8 max-w-2xl mx-auto">
                        @if(isset($blogs) && $blogs->count() > 0)
                            Rehberlerimizde bulamadığınız sorular için
                        @else
                            Mikrofon süngeri seçimi ve kullanımı konusundaki tüm sorularınız için
                        @endif
                        uzman ekibimizle iletişime geçin. Hızlı ve profesyonel destek garantisi.
                    </p>
                    
                    <x-contact-buttons />
                </div>
            </div>
        </div>
    </div>
@endsection
