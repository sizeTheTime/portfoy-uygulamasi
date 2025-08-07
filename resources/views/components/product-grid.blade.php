{{-- filepath: resources/views/components/product-grid.blade.php --}}
@props([
    'products' => collect(),
    'defaultImage' => '',
])

<div class="mt-4">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
        @foreach ($products as $product)
            <div class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:border-gray-200 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800 dark:hover:border-gray-600"
                @mouseenter="changeImage('{{ asset('storage/' . $product->cardImage->main_image) }}')"
                @mouseleave="changeImage('{{ $defaultImage }}')">

                <!-- Product Image -->
                <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-700">
                    <img src="{{ asset('storage/' . $product->cardImage->main_image) }}"
                        alt="{{ $product->cardImage->main_image_alt ?? $product->name }}"
                        class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110"
                        loading="lazy" />

                    <!-- Hover overlay with subtle animation -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                    </div>
                </div>

                <!-- Price Badge -->
                <div class="absolute top-4 right-4">
                    <div
                        class="rounded-full bg-gradient-to-r from-green-900 via-green-700 to-green-400/10 px-3 py-1.5 text-sm font-semibold text-white shadow-lg transform transition-transform duration-300 group-hover:scale-105">
                        {{ number_format($product->price, 2, ',', '.') }} TL
                    </div>
                </div>

                <!-- Title Overlay -->
                <div class="absolute bottom-0 w-full bg-gradient-to-t from-gray-900 via-gray-800/90 to-transparent">
                    <h3
                        class="mb-2 line-clamp-1 p-4 text-base text-white drop-shadow-lg transform transition-transform duration-300 group-hover:translate-y-[-2px]">
                        {{ $product->name }}
                    </h3>
                </div>

                <!-- Action Button -->
                <div
                    class="absolute right-4 bottom-4 left-4 translate-y-2 transform opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                    <a href="{{ route('product.show', ['category_slug' => $product->category->slug, 'product_slug' => $product->slug]) }}"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-green-700 px-4 py-2.5 font-medium text-white shadow-lg transition-all duration-200 hover:from-green-700 hover:to-green-800 hover:shadow-xl hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6 transition-transform duration-200 group-hover:translate-x-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                        </svg>
                        <span>Sayfayı Görüntüle</span>
                    </a>
                </div>

                <!-- Enhanced Hover Border Effect -->
                <div
                    class="pointer-events-none absolute inset-0 rounded-2xl border-2 border-transparent transition-all duration-300 group-hover:border-green-400/50 group-hover:shadow-[0_0_20px_rgba(34,197,94,0.3)] dark:group-hover:border-green-500/50">
                </div>

            </div>
        @endforeach
    </div>
</div>
