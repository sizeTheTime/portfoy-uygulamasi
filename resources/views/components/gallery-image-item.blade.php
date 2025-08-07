@props(['image', 'index', 'total'])

<button @click="changeImage('{{ asset('storage/' . $image->main_image) }}')"
    class="aspect-square rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 hover:border-blue-500 transition-all duration-300 focus:outline-none focus:border-blue-500 group relative"
    x-data="{
        isHovered: false,
        isLoading: false,
        imageLoaded: false,
        imageError: false
    }" @mouseenter="isHovered = true" @mouseleave="isHovered = false"
    :class="{ 'scale-105 shadow-lg': isHovered }">

    <!-- Main Image -->
    <div class="absolute inset-0 transition-all duration-500 ease-in-out"
        :class="{
            'opacity-100 scale-100': !isHovered,
            'opacity-0 scale-110': isHovered
        }">
        <img src="{{ asset('storage/' . $image->main_image) }}" alt="{{ $image->main_image_alt }}"
            class="w-full h-full object-cover" loading="lazy" @load="imageLoaded = true" @error="imageError = true">
    </div>

    <!-- Hover Image -->
    <div class="absolute inset-0 transition-all duration-500 ease-in-out"
        :class="{
            'opacity-0 scale-90': !isHovered,
            'opacity-100 scale-100': isHovered
        }">
        <img src="{{ asset('storage/' . $image->hover_image) }}" alt="{{ $image->hover_image_alt }}"
            class="w-full h-full object-cover" loading="lazy">
    </div>

    <!-- Loading Overlay -->
    <div class="absolute inset-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center transition-opacity duration-300"
        x-show="isLoading" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="w-6 h-6 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    <!-- Error State -->
    <div class="absolute inset-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center" x-show="imageError"
        x-transition>
        <div class="text-gray-400 text-center">
            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            <span class="text-xs">Resim yüklenemedi</span>
        </div>
    </div>

    <!-- Hover Overlay Effect -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent transition-opacity duration-300"
        :class="{ 'opacity-100': isHovered, 'opacity-0': !isHovered }">
    </div>

    <!-- Click Ripple Effect -->
    <div class="absolute inset-0 rounded-lg" x-show="false" x-ref="ripple"
        @click="
             $refs.ripple.style.background = 'radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, transparent 70%)';
             $refs.ripple.style.transform = 'scale(0)';
             $el.style.display = 'block';
             setTimeout(() => {
                 $refs.ripple.style.transform = 'scale(4)';
                 $refs.ripple.style.opacity = '0';
             }, 10);
             setTimeout(() => {
                 $el.style.display = 'none';
                 $refs.ripple.style.opacity = '1';
             }, 600);
         "
        class="transition-all duration-600 ease-out pointer-events-none">
    </div>

    <!-- Image Counter Badge -->
    <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full transition-all duration-300"
        :class="{
            'opacity-100 translate-y-0': isHovered,
            'opacity-0 -translate-y-2': !isHovered
        }">
        {{ $index }}/{{ $total }}
    </div>
</button>
