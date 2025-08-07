{{-- filepath: resources/views/pages/home.blade.php --}}
@extends('layouts.default')

@section('title', 'Bi Mikrofon Süngeri | Kurumsal')
@section('description', 'Mikrofon süngeri üretiminde lider, özelleştirilmiş logo baskılı mikrofon süngerleri ile
    markanızı duyurun.')

@section('content')
    <section class="w-full py-4 md:py-16 lg:py-20">
        <div class="container max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 lg:gap-12 items-center">
                <!-- Görsel -->
                <div class="order-1 flex justify-center">
                    <div class="rounded-lg overflow-hidden w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-96">
                        <img src="/assets/images/kurumsal/anka-ulusal-haber-ajansi-kare-mikrofon-sungeri-logo-baskili.jpg"
                            alt="Logo baskılı mikrofon süngerleri" class="w-full h-auto object-cover rounded-lg shadow-md" />
                    </div>
                </div>

                <!-- İçerik -->
                <div class="order-2 space-y-4 sm:space-y-6 text-center lg:text-left">
                    <h1
                        class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-[48px]
                               font-medium text-[#0d0d0d] leading-snug sm:leading-tight px-2 sm:px-0">
                        Özelleştirilmiş Logo Baskılı Mikrofon Süngerleri
                    </h1>

                    <p
                        class="text-sm sm:text-base text-[#808080] leading-relaxed
                              px-2 sm:px-0 max-w-lg mx-auto lg:mx-0">
                        Markanızı duyurmanızı sağlayan, yüksek kaliteli malzeme ve net baskı ile hazırlanan logo baskılı
                        mikrofon süngerleri. Yayın, tanıtım ve etkinliklerinizde profesyonelliğinizi bir adım öteye taşıyın.
                    </p>
                    <x-contact-buttons />

                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-8 sm:py-12 lg:py-16 px-4 sm:px-6 lg:px-8 bg-gray-50/30">
        <div class="max-w-5xl mx-auto">
            <h2
                class="text-2xl sm:text-3xl md:text-4xl lg:text-[48px]
                       font-medium leading-snug sm:leading-tight text-center
                       text-[#0d0d0d] mb-8 sm:mb-12 lg:mb-16 px-2">
                Hayallerinizi Sesle Şekillendiriyoruz
            </h2>

            <div class="flex flex-col lg:flex-row items-center gap-6 sm:gap-8 lg:gap-12">
                <div class="w-full lg:w-1/2 space-y-4 sm:space-y-6 text-center lg:text-left">
                    <span class="text-[#3328bf] font-medium text-sm sm:text-base">Hakkımızda</span>

                    <h3
                        class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold
                               text-[#0d0d0d] leading-snug sm:leading-tight px-2 sm:px-0">
                        Profesyonel Mikrofon Süngeri Hizmetleri
                    </h3>

                    <p
                        class="text-sm sm:text-base text-[#808080] leading-relaxed
                              px-2 sm:px-0 max-w-lg mx-auto lg:mx-0">
                        Ses kayıtlarınızda ve canlı yayınlarınızda temiz, net ve güçlü bir ses için geliştirilmiş
                        mikrofon sünger çözümleri sunuyoruz. Logo baskılı modellerimizle marka görünürlüğünüzü
                        artırırken, ses kalitesinden asla ödün vermeyin.
                    </p>
                    <x-contact-buttons />

                </div>

                <div class="w-full lg:w-1/2 flex justify-center">
                    <div class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-96">
                        <img src="/assets/images/kurumsal/trt-turku-ulusal-tv-kanali-mikrofon-sungeri-logo-baskili.jpg"
                            alt="Profesyonel mikrofon sünger uygulaması"
                            class="w-full h-auto object-cover rounded-2xl shadow-lg" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
