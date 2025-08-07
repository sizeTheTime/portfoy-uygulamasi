{{-- filepath: resources/views/pages/blog-show.blade.php --}}
@extends('layouts.app')

@section('title', $blog->title)
@section('meta_description', $blog->excerpt)

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-4">{{ $blog->title }}</h1>
        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}"
            class="mb-6 rounded-xl w-full h-64 object-cover">
        <div class="text-gray-600 mb-4">{{ $blog->excerpt }}</div>

        <!-- Contact CTA -->
        <section class="text-center">
            <div class="bg-white rounded-2xl p-8 border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Mikrofon Süngeri İhtiyacınız İçin
                </h2>
                <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                    Blog yazılarımızda bulamadığınız sorularınız için uzman ekibimizle iletişime geçin. Profesyonel
                    danışmanlık ve hızlı çözümler için buradayız.
                </p>
                <div class="flex items-center justify-center">
                    <x-contact-buttons />
                </div>
            </div>
        </section>
        <div class="prose max-w-none">{!! $blog->content !!}</div>
    </div>
@endsection
