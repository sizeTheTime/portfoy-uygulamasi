{{-- filepath: resources/views/components/product-image-display.blade.php --}}
@props([
    'currentImage' => '',
    'isTransitioning' => false,
])

<div class="flex items-center justify-center h-full relative overflow-hidden max-h-[calc(100vh-100px)]">
    <!-- Background blur effect during transition -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 transition-opacity duration-300"
        :class="{ 'opacity-20': isTransitioning, 'opacity-0': !isTransitioning }">
    </div>

    <!-- Main image with enhanced animations -->
    <div class="relative max-w-full max-h-full transition-all duration-500 ease-out"
        :class="{
            'scale-95 blur-sm': isTransitioning,
            'scale-100 blur-0': !isTransitioning
        }">
        <img :src="currentImage" alt="Ürün görseli"
            class="max-w-full max-h-full object-cover transition-all duration-500 ease-out transform"
            :class="{
                'opacity-0 scale-110': isTransitioning,
                'opacity-100 scale-100': !isTransitioning
            }" />
    </div>

    <!-- Loading indicator -->
    <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-200"
        :class="{ 'opacity-100': isTransitioning, 'opacity-0': !isTransitioning }">
        <div class="w-8 h-8 border-2 border-green-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- Decorative elements -->
    <div class="absolute top-4 right-4 w-20 h-20 bg-gradient-to-br from-green-400/10 to-blue-400/10 rounded-full blur-xl transition-opacity duration-500"
        :class="{ 'opacity-0': isTransitioning, 'opacity-100': !isTransitioning }">
    </div>
    <div class="absolute bottom-4 left-4 w-16 h-16 bg-gradient-to-br from-purple-400/10 to-pink-400/10 rounded-full blur-xl transition-opacity duration-500"
        :class="{ 'opacity-0': isTransitioning, 'opacity-100': !isTransitioning }">
    </div>

</div>
