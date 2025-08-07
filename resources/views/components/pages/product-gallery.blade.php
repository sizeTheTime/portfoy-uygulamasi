@props(['images', 'productSlug', 'totalImagesCount' => 0, 'hasMoreImages' => false])

<div class="space-y-4" x-data="productGallery(@js($productSlug), @js($totalImagesCount), @js($hasMoreImages))">
    <!-- Gallery Grid -->
    <div class="grid grid-cols-2  md:grid-cols-4 gap-3 mb-5" x-ref="galleryGrid">
        <!-- Initial Images -->
        @if ($images && count($images) > 0)
            @foreach ($images as $image)
                <button x-on:click="selectImage('{{ asset('storage/' . $image->main_image) }}')"
                    class="aspect-square rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 hover:border-blue-500 transition-all duration-300 focus:outline-none focus:border-blue-500 group relative"
                    x-data="{
                        isHovered: false,
                        isLoading: false,
                        imageLoaded: false,
                        imageError: false
                    }" x-on:mouseenter="isHovered = true" x-on:mouseleave="isHovered = false"
                    :class="{ 'scale-105 shadow-lg': isHovered }">

                    <!-- Main Image -->
                    <div class="absolute inset-0 transition-all duration-500 ease-in-out"
                        :class="{
                            'opacity-100 scale-100': !isHovered,
                            'opacity-0 scale-110': isHovered
                        }">
                        <img src="{{ asset('storage/' . $image->main_image) }}" alt="{{ $image->main_image_alt }}"
                            class="w-full h-full object-cover" loading="lazy" x-on:load="imageLoaded = true"
                            x-on:error="imageError = true">
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
                        x-show="isLoading" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <div class="w-6 h-6 border-2 border-blue-600 border-t-transparent rounded-full animate-spin">
                        </div>
                    </div>

                    <!-- Error State -->
                    <div class="absolute inset-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center"
                        x-show="imageError" x-transition>
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
                    <div class="absolute inset-0 rounded-lg" x-show="false" x-ref="ripple_{{ $loop->index }}"
                        x-on:click="createRippleEffect($refs.ripple_{{ $loop->index }})"
                        class="transition-all duration-600 ease-out pointer-events-none">
                    </div>

                    <!-- Image Counter Badge -->
                    <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full transition-all duration-300"
                        :class="{
                            'opacity-100 translate-y-0': isHovered,
                            'opacity-0 -translate-y-2': !isHovered
                        }">
                        {{ $loop->iteration }}/{{ $totalImagesCount }}
                    </div>
                </button>
            @endforeach
        @endif

        <!-- Dynamically Loaded Images Container -->
        <template x-for="(image, index) in loadedImages" :key="image.id">
            <button x-on:click="selectImage(getImageUrl(image.main_image))"
                class="aspect-square rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-600 hover:border-blue-500 transition-all duration-300 focus:outline-none focus:border-blue-500 group relative cursor-pointer"
                x-data="{
                    isHovered: false,
                    isLoading: false,
                    imageLoaded: false,
                    imageError: false
                }" x-on:mouseenter="isHovered = true" x-on:mouseleave="isHovered = false"
                :class="{ 'scale-105 shadow-lg': isHovered }">

                <!-- Main Image -->
                <div class="absolute inset-0 transition-all duration-500 ease-in-out"
                    :class="{
                        'opacity-100 scale-100': !isHovered,
                        'opacity-0 scale-110': isHovered
                    }">
                    <img :src="getImageUrl(image.main_image)" :alt="image.main_image_alt"
                        class="w-full h-full object-cover" loading="lazy" x-on:load="imageLoaded = true"
                        x-on:error="imageError = true">
                </div>

                <!-- Hover Image -->
                <div class="absolute inset-0 transition-all duration-500 ease-in-out"
                    :class="{
                        'opacity-0 scale-90': !isHovered,
                        'opacity-100 scale-100': isHovered
                    }">
                    <img :src="getImageUrl(image.hover_image)" :alt="image.hover_image_alt"
                        class="w-full h-full object-cover" loading="lazy">
                </div>

                <!-- Loading Overlay -->
                <div class="absolute inset-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center transition-opacity duration-300"
                    x-show="isLoading" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <div class="w-6 h-6 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                </div>

                <!-- Error State -->
                <div class="absolute inset-0 bg-gray-100 dark:bg-gray-800 flex items-center justify-center"
                    x-show="imageError" x-transition>
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
                <div class="absolute inset-0 rounded-lg" x-show="false" x-ref="dynamicRipple"
                    x-on:click="createRippleEffect($refs.dynamicRipple)"
                    class="transition-all duration-600 ease-out pointer-events-none">
                </div>

                <!-- Image Counter Badge -->
                <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded-full transition-all duration-300"
                    :class="{
                        'opacity-100 translate-y-0': isHovered,
                        'opacity-0 -translate-y-2': !isHovered
                    }"
                    x-text="`${index + {{ count($images ?? []) }} + 1}/${totalImagesCount}`">
                </div>
            </button>
        </template>
    </div>

    <!-- Load More Button Component -->
    <x-pages.load-more-button :has-more-images="'hasMoreImages'" :is-loading-more="'isLoadingMore'" />

    <!-- Gallery Info -->
    <div class="text-center text-sm text-gray-500 dark:text-gray-400" x-data="{ show: false }" x-intersect="show = true"
        x-show="show" x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
        <span x-text="`${currentLoadedCount}/${totalImagesCount} görsel`"></span>
        <span class="mx-2">•</span>
        <span>Büyütmek için tıklayın</span>
    </div>
</div>

<script>
    function productGallery(productSlug, totalImages, hasMore) {
        return {
            productSlug: productSlug,
            loadedImages: [],
            currentOffset: {{ count($images ?? []) }},
            totalImagesCount: totalImages,
            hasMoreImages: hasMore,
            isLoadingMore: false,
            currentLoadedCount: {{ count($images ?? []) }},

            // Ana view'a resim seçimi event'i gönder
            selectImage(imageUrl) {
                this.$dispatch('image-selected', {
                    imageUrl: imageUrl
                });
                this.createRippleEffect();
            },

            async loadMoreImages() {
                if (this.isLoadingMore || !this.hasMoreImages) return;

                this.isLoadingMore = true;

                try {
                    const response = await fetch(
                        `/products/${this.productSlug}/load-more-images?offset=${this.currentOffset}&limit=4`);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.images && data.images.length > 0) {
                        // Add new images to the array
                        this.loadedImages.push(...data.images);
                        this.currentOffset += data.images.length;
                        this.currentLoadedCount += data.images.length;
                        this.hasMoreImages = data.hasMore;
                        this.totalImagesCount = data.totalCount;

                        // Animate new images
                        this.$nextTick(() => {
                            const newImages = this.$refs.galleryGrid.querySelectorAll(
                                '.aspect-square:nth-last-child(-n+' + data.images.length + ')');
                            newImages.forEach((img, index) => {
                                img.style.opacity = '0';
                                img.style.transform = 'translateY(20px)';
                                setTimeout(() => {
                                    img.style.transition = 'all 0.5s ease-out';
                                    img.style.opacity = '1';
                                    img.style.transform = 'translateY(0)';
                                }, index * 100);
                            });
                        });

                        // Success notification
                        this.$dispatch('notify', {
                            type: 'success',
                            message: `${data.images.length} yeni resim yüklendi!`
                        });
                    }
                } catch (error) {
                    console.error('Error loading more images:', error);

                    // User-friendly error message
                    this.$dispatch('notify', {
                        type: 'error',
                        message: 'Resimler yüklenirken bir hata oluştu. Lütfen tekrar deneyin.'
                    });
                } finally {
                    this.isLoadingMore = false;
                }
            },

            getImageUrl(imagePath) {
                return `/storage/${imagePath}`;
            },

            createRippleEffect(rippleEl) {
                if (!rippleEl) return;

                rippleEl.style.background = 'radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, transparent 70%)';
                rippleEl.style.transform = 'scale(0)';
                rippleEl.style.display = 'block';

                setTimeout(() => {
                    rippleEl.style.transform = 'scale(4)';
                    rippleEl.style.opacity = '0';
                }, 10);

                setTimeout(() => {
                    rippleEl.style.display = 'none';
                    rippleEl.style.opacity = '1';
                }, 600);
            }
        }
    }
</script>
