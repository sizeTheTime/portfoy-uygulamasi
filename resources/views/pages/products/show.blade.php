@extends('layouts.app')
@section('title', $product->name . ' | Bimikrofon Süngeri')
@section('meta_description', $product->description)

@push('structured-data')
    <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
    <div class="grid grid-cols-12 max-h-[calc(100vh-100px)] overflow-hidden" x-data="{
        currentImage: '{{ asset('storage/' . $product->cardImage->main_image) }}',
        selectedColor: null,
        isTransitioning: false,
    
        changeImage(newImage) {
            if (this.currentImage !== newImage) {
                this.isTransitioning = true;
                setTimeout(() => {
                    this.currentImage = newImage;
                    setTimeout(() => {
                        this.isTransitioning = false;
                    }, 50);
                }, 200);
            }
        }
    }"
        x-on:image-selected.window="changeImage($event.detail.imageUrl)">

        <x-left-content>
            <div class="col-span-1 md:col-span-3 relative flex md:flex-row flex-col-reverse font-outfit text-[#121990] bg-contain bg-center rounded-md "
                style="background-image: url('/assets/images/bg/bg-banner.png')">
                <div class="space-y-7 lg:p-8 w-full">
                    <!-- Product Header -->
                    <x-pages.product-header :name="$product->name" :description="$product->description" />
                    <x-pages.product-attributes :items="$product->attributes" />
                    <x-pages.color-options :colors="$product->colors" />
                    <x-contact-buttons />

                    <x-pages.note />
                </div>
                <x-pages.card-image :image="$product->cardImage->secondary_image" :alt="$product->cardImage->secondary_image_alt" />
            </div>
            <!-- Product Gallery Thumbnails -->
            <x-pages.product-gallery :images="$product->images" :product-slug="$product->slug" :total-images-count="$totalImagesCount" :has-more-images="$hasMoreImages" />

        </x-left-content>


        <x-right-content>
            <x-product-image-display :main-image="asset('storage/' . $product->cardImage->main_image)" :hover-image="asset('storage/' . $product->cardImage->hover_image)" :is-transitioning="'isTransitioning'" />
        </x-right-content>
    </div>
@endsection
