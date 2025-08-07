{{-- filepath: resources/views/pages/home.blade.php --}}
@extends('layouts.app')
@section('title', 'Bi Mikrofon Süngeri | İletişim')
@section('description', 'Mikrofon süngeri üretiminde lider, özelleştirilmiş logo baskılı mikrofon süngerleri ile
    markanızı duyurun.')

@section('content')
    <!-- Main Content -->
    <div class="bg-gray-50 min-h-screen md:mt-16 lg:mt-0  md:mb-20 lg:mb-0 ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <!-- Contact Information Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12 bg-white shadow-[0_0px_10px_4px_rgba(0,0,0,0.1)] ">
                <!-- Company Information Card -->
                <div class=" p-6 sm:p-8">
                    <div class="flex items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">İletişim Bilgileri</h2>
                    </div>
                    <div class="space-y-6">
                        <!-- Address -->
                        <div
                            class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div
                                class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Genel Müdürlük</h3>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    İstanbul, Fatih, Akşemsettin Mah.<br>
                                    Şehit Teğmen Mehmet Sarper Alus Sok., 53
                                </p>
                            </div>
                        </div>
                        <!-- Phone -->
                        <div
                            class="flex items-start space-x-4 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">Müşteri Hizmetleri</h3>
                                <a href="tel:+902123813150"
                                    class="text-green-600 hover:text-green-700 font-semibold text-lg">
                                    +90 (212) 381 31 50
                                </a>
                                <p class="text-gray-500 text-xs mt-1">
                                    Hafta içi: 09:00 - 21:00 / Hafta sonu: 09:00 - 21:00
                                </p>
                            </div>
                        </div>
                        <!-- Email -->
                        <div
                            class="flex items-start space-x-4 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-2">E-posta Adresleri</h3>
                                <div class="space-y-1">
                                    <a href="mailto:info@mikrofonbaskisi.com"
                                        class="block text-purple-600 hover:text-purple-700 font-medium">
                                        info@bimikrofonsungeri.com
                                    </a>
                                    <a href="mailto:siparis@mikrofonbaskisi.com"
                                        class="block text-purple-600 hover:text-purple-700 font-medium">
                                        siparis@bimikrofonsungeri.com
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile -->
                        <div
                            class="flex items-start space-x-4 p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800 mb-1">İletişim Hattı</h3>
                                <a href="tel:+905358757884"
                                    class="text-orange-600 hover:text-orange-700 font-semibold text-lg">
                                    0(535) 875 78 84
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Map Card -->
                <div class="overflow-hidden">
                    <div class="h-[300px] sm:h-[400px] lg:h-full relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3010.328391318128!2d28.9456155!3d41.0180709!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cabb4c4f5cc8a7%3A0x184c2219df40e307!2sBi%20mikrofon%20s%C3%BCngeri!5e0!3m2!1str!2str!4v1752022797671!5m2!1str!2str"
                            width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <!-- Services Section -->
            <div class="bg-white p-6 sm:p-8 border border-gray-100">
                <div class="text-center mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        <span class="text-gray-800">
                            Hizmetlerimiz & Site Haritası
                        </span>
                    </h2>
                    <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Silindir, kare, üçgen, top, damla ve reklam küpü mikrofon süngeri modellerimiz ile kurumsal ve
                        bireysel
                        baskı çözümlerinde profesyonel hizmet sunuyoruz. Hemen keşfedin!
                    </p>
                </div>
                <!-- Main Content Grid -->
                <div class="gap-12">
                    <!-- Ana Sayfalar -->
                    <div class="lg:col-span-2">
                        <h2 class="text-2xl font-medium text-black mb-8 pb-3 border-b border-gray-300">Ana Sayfalar
                        </h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="group">
                                <a href="{{ route('anasayfa') }}"
                                    class="block bg-white p-6 border border-gray-200 hover:border-black transition-all duration-300">
                                    <h3 class="text-lg font-medium text-black mb-2 group-hover:text-gray-600">Anasayfa
                                    </h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">Ana sayfa ve genel bilgiler</p>
                                </a>
                            </div>
                            <div class="group">
                                <a href="{{ route('kurumsal') }}"
                                    class="block bg-white p-6 border border-gray-200 hover:border-black transition-all duration-300">
                                    <h3 class="text-lg font-medium text-black mb-2 group-hover:text-gray-600">Kurumsal
                                    </h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">Şirket hakkında bilgiler ve
                                        kurumsal kimlik</p>
                                </a>
                            </div>
                            <div class="group">
                                <a href="{{ route('blog') }}"
                                    class="block bg-white p-6 border border-gray-200 hover:border-black transition-all duration-300">
                                    <h3 class="text-lg font-medium text-black mb-2 group-hover:text-gray-600">Blog</h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">Güncel haberler, makaleler ve
                                        duyurular</p>
                                </a>
                            </div>
                            <div class="group">
                                <a href="{{ route('iletisim') }}"
                                    class="block bg-white p-6 border border-gray-200 hover:border-black transition-all duration-300">
                                    <h3 class="text-lg font-medium text-black mb-2 group-hover:text-gray-600">İletişim
                                    </h3>
                                    <p class="text-gray-500 text-sm leading-relaxed">İletişim bilgileri ve iletişim
                                        formu</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
