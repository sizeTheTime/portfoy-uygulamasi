<template>
    <AppLayout>
        <div class="grid max-h-[calc(100vh-100px)] grid-cols-12 overflow-hidden">
            <!-- Sol Panel -->
            <div class="font-outfit custom-scroll col-span-12 max-h-[calc(100vh-90px)] overflow-y-scroll px-12 py-5 pb-32 lg:col-span-7">
                <div class="grid gap-8 md:grid-cols-3">
                    <!-- Ana Ürün Bilgileri Bölümü -->
                    <section
                        class="font-outfit relative col-span-1 flex flex-col-reverse overflow-hidden rounded-md bg-transparent bg-contain bg-center md:col-span-3 md:flex-row lg:mx-8"
                    >
                        <!-- Ürün Bilgileri Düzenleme Butonu -->
                        <div class="absolute top-2 right-2 z-10">
                            <Link
                                :href="route('pages.edit.information', product.id)"
                                class="inline-flex items-center rounded-full bg-blue-600 p-2 text-white shadow-lg transition-all duration-200 hover:bg-blue-700 hover:scale-105"
                                title="Ürün bilgilerini düzenle"
                            >
                                <EditIcon class="h-4 w-4" />
                            </Link>
                        </div>

                        <div class="w-full space-y-7 lg:p-8">
                            <h1 class="pt-3 text-2xl font-semibold text-gray-900 sm:text-3xl dark:text-white">
                                {{ product.name }}
                            </h1>
                            <p class="max-w-xl text-sm leading-6 font-normal text-gray-700 sm:text-base dark:text-gray-300">
                                {{ product.description }}
                            </p>

                            <!-- Ürün Boyutları ve Diğer Özellikler -->
                            <div v-if="product.attributes && product.attributes.length > 0" class="mb-6 relative">
                                <!-- Özellikler Düzenleme Butonu -->
                                <div class="absolute -top-2 -right-2 z-10">
                                    <Link
                                        :href="route('pages.edit.attributes', product.id)"
                                        class="inline-flex items-center rounded-full bg-green-600 p-1.5 text-white shadow-lg transition-all duration-200 hover:bg-green-700 hover:scale-105"
                                        title="Ürün özelliklerini düzenle"
                                    >
                                        <SettingsIcon class="h-3 w-3" />
                                    </Link>
                                </div>

                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div
                                        v-for="attr in product.attributes"
                                        :key="attr.id"
                                        class="rounded-lg border border-blue-100 bg-transparent p-3 text-center dark:border-blue-800"
                                    >
                                        <div class="font-semibold text-blue-800 dark:text-blue-300">{{ attr.name }}</div>
                                        <div class="text-blue-600 dark:text-blue-400">{{ attr.value }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Renk Seçenekleri -->
                            <div v-if="product.colors && product.colors.length > 0" class="space-y-3 relative">
                                <!-- Renkler Düzenleme Butonu -->
                                <div class="absolute -top-2 -right-2 z-10">
                                    <Link
                                        :href="route('pages.edit.colors', product.id)"
                                        class="inline-flex items-center rounded-full bg-purple-600 p-1.5 text-white shadow-lg transition-all duration-200 hover:bg-purple-700 hover:scale-105"
                                        title="Ürün renklerini düzenle"
                                    >
                                        <PaletteIcon class="h-3 w-3" />
                                    </Link>
                                </div>

                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Renk Seçenekleri</h3>
                                <div class="grid grid-cols-4 gap-3 sm:grid-cols-6">
                                    <div v-for="color in product.colors" :key="color.id" class="group relative cursor-pointer">
                                        <div
                                            class="h-12 w-12 rounded-full border-2 border-gray-200 shadow-sm ring-2 ring-transparent transition-transform group-hover:scale-110 group-hover:ring-gray-300 dark:border-gray-600 dark:group-hover:ring-gray-500"
                                            :style="{ backgroundColor: color.hex_code }"
                                            :title="color.name"
                                        ></div>
                                        <div
                                            class="absolute -bottom-6 left-1/2 z-10 -translate-x-1/2 transform opacity-0 transition-opacity group-hover:opacity-100"
                                        >
                                            <div
                                                class="rounded bg-gray-900 px-2 py-1 text-xs whitespace-nowrap text-white shadow-lg dark:bg-gray-700"
                                            >
                                                {{ color.name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- İletişim Butonları -->
                            <div class="pt-2">
                                <div class="flex w-full flex-col gap-3 sm:flex-row">
                                    <!-- WhatsApp Butonu -->
                                    <a
                                        href="https://wa.me/905358757884?text=Merhaba,%20ahsap%20plaket%20hakkında%20bilgi%20almak%20istiyorum."
                                        class="inline-flex w-full transform items-center justify-center rounded-lg bg-gradient-to-r from-green-500 to-green-600 px-6 py-3 text-center text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:from-green-600 hover:to-green-700 hover:shadow-xl sm:w-auto"
                                        title="WhatsApp ile iletişime geçin"
                                        target="_blank"
                                    >
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.700"
                                            />
                                        </svg>
                                        <span class="text-base font-semibold text-white uppercase">WhatsApp</span>
                                    </a>
                                    <!-- Telefon Butonu -->
                                    <a
                                        href="tel:+905358757884"
                                        class="inline-flex w-full transform items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-3 text-center text-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:from-blue-600 hover:to-blue-700 hover:shadow-xl sm:w-auto"
                                        title="Telefon ile arayın"
                                    >
                                        <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"
                                            />
                                        </svg>
                                        <span class="text-base font-semibold text-white uppercase">Ara</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Fiyat Bilgisi -->
                            <div class="rounded-lg border border-blue-200 bg-transparent p-4 dark:border-blue-800">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-900 dark:text-blue-300">
                                        {{ formatPrice(product.price) }}
                                    </div>
                                    <div v-if="product.category" class="mt-1 text-sm text-blue-600 dark:text-blue-400">
                                        {{ product.category.name }}
                                    </div>
                                </div>
                            </div>

                            <!-- Ek Bilgiler -->
                            <div class="rounded-lg border border-yellow-200 bg-transparent p-3 dark:border-yellow-800">
                                <div class="flex items-start">
                                    <InfoIcon class="mt-0.5 mr-2 h-5 w-5 flex-shrink-0 text-yellow-600 dark:text-yellow-400" />
                                    <div class="text-sm text-yellow-800 dark:text-yellow-300">
                                        <strong>Not:</strong> Tüm renkler logo baskısı için uygundur. Özel renk talepleriniz için bizimle iletişime
                                        geçin.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ana Ürün Resmi (Sol panelde, mobil için) -->
                        <img
                            v-if="allImages && allImages.length > 0"
                            :src="getImageUrl(allImages[0].main_image)"
                            :alt="allImages[0].main_image_alt || product.name"
                            class="w-64 object-contain sm:w-64"
                            loading="lazy"
                            width="300"
                            height="350"
                            @error="handleImageError"
                        />
                    </section>

                    <!-- Ürün Galerisi - allImages kullan -->
                    <div class="relative col-span-1 md:col-span-3">
                        <!-- Galeri Düzenleme Butonu -->
                        <div class="absolute top-2 right-2 z-20">
                            <Link
                                :href="route('pages.edit.gallery', product.id)"
                                class="inline-flex items-center rounded-full bg-orange-600 p-2 text-white shadow-lg transition-all duration-200 hover:bg-orange-700 hover:scale-105"
                                title="Galeriyi düzenle"
                            >
                                <ImageIcon class="h-4 w-4" />
                            </Link>
                        </div>

                        <div class="grid gap-8 md:grid-cols-3">
                            <div v-for="(image, index) in allImages" :key="index" class="group relative cursor-pointer" @click="selectImage(image, index)">
                                <img
                                    :src="getImageUrl(image.main_image)"
                                    :alt="image.main_image_alt || `${product.name} - Model ${index + 1}`"
                                    class="h-60 w-full rounded-lg border-2 border-gray-200 object-cover transition-all duration-300 group-hover:scale-[1.02] hover:border-blue-300 hover:shadow-lg sm:h-72 dark:border-gray-700 dark:hover:border-blue-600 dark:hover:shadow-2xl"
                                    @error="handleImageError"
                                />
                                <img
                                    v-if="image.hover_image"
                                    :src="getImageUrl(image.hover_image)"
                                    :alt="image.hover_image_alt || `${product.name} - Hover`"
                                    class="pointer-events-none absolute inset-0 h-60 w-full scale-90 rounded-lg object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100 sm:h-72"
                                    @error="handleImageError"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Daha Fazla Göster Butonu - Yeni tasarım -->
                    <div v-if="hasMoreImages && !loadingMore" class="col-span-1 flex justify-center md:col-span-3">
                        <button
                            @click="loadMoreImages"
                            :disabled="loadingMore"
                            class="group relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 px-8 py-4 font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:shadow-xl hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100 dark:from-blue-700 dark:via-blue-800 dark:to-indigo-800 dark:hover:from-blue-800 dark:hover:via-blue-900 dark:hover:to-indigo-900"
                        >
                            <!-- Shimmer effect -->
                            <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-1000 group-hover:translate-x-full"></div>

                            <!-- Button content -->
                            <div class="relative flex items-center gap-3">
                                <!-- Loading spinner -->
                                <div v-if="loadingMore" class="flex items-center gap-3">
                                    <div class="h-5 w-5 animate-spin rounded-full border-2 border-white/30 border-t-white"></div>
                                    <span class="text-base">Yükleniyor...</span>
                                </div>

                                <!-- Normal state -->
                                <div v-else class="flex items-center gap-3">
                                    <!-- Icon -->
                                    <svg class="h-5 w-5 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8l-8 8-8-8"></path>
                                    </svg>

                                    <!-- Text -->
                                    <div class="flex flex-col items-start">
                                        <span class="text-base font-semibold">Daha Fazla Göster</span>
                                        <span class="text-xs text-blue-100">{{ remainingImagesCount }} resim kaldı</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Pulse effect on hover -->
                            <div class="absolute inset-0 rounded-xl bg-white/10 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                        </button>
                    </div>

                    <!-- Loading State -->
                    <div v-if="loadingMore" class="col-span-1 flex justify-center py-8 md:col-span-3">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <div class="h-6 w-6 animate-spin rounded-full border-b-2 border-blue-600"></div>
                            <span>Resimler yükleniyor...</span>
                        </div>
                    </div>

                    <!-- Kart Bilgileri -->
                    <div
                        v-if="product.card_images && product.card_images.length > 0"
                        class="col-span-1 rounded-lg border border-gray-200 bg-transparent p-6 shadow-sm md:col-span-3 dark:border-gray-700 relative"
                    >
                        <!-- Kart Bilgileri Düzenleme Butonu -->
                        <div class="absolute top-2 right-2 z-10">
                            <Link
                                :href="route('pages.edit.card', product.id)"
                                class="inline-flex items-center rounded-full bg-indigo-600 p-2 text-white shadow-lg transition-all duration-200 hover:bg-indigo-700 hover:scale-105"
                                title="Kart bilgilerini düzenle"
                            >
                                <CreditCardIcon class="h-4 w-4" />
                            </Link>
                        </div>

                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Ek Bilgiler</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div
                                v-for="card in product.card_images"
                                :key="card.id"
                                class="flex flex-col gap-4 rounded-lg border border-gray-100 bg-transparent p-4 sm:flex-row dark:border-gray-600"
                            >
                                <div v-if="card.main_image" class="flex-shrink-0">
                                    <img
                                        :src="getImageUrl(card.main_image)"
                                        :alt="card.main_image_alt"
                                        class="h-32 w-32 rounded-lg border border-gray-200 object-cover shadow-sm dark:border-gray-600"
                                        @error="handleImageError"
                                    />
                                </div>
                                <div class="flex-1">
                                    <h4 class="mb-2 font-semibold text-gray-900 dark:text-white">{{ card.title }}</h4>
                                    <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300">{{ card.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sağ Panel (Desktop) -->
            <div v-if="!isMobile" class="relative col-span-0 flex items-center justify-center lg:col-span-5">
                <div class="w-full space-y-4 p-4 text-center">
                    <div class="absolute top-12 right-8 z-50">
                        <div
                            class="rounded bg-gradient-to-r from-blue-600/80 to-blue-700/70 px-3 py-1.5 text-base font-semibold text-white shadow-lg"
                        >
                            {{ formatPrice(product.price) }}
                        </div>
                    </div>
                    <!-- Ana Resim Container -->
                    <div class="relative mx-auto max-h-[750px] w-full overflow-hidden rounded-lg bg-gray-100 shadow-2xl dark:bg-gray-800">
                        <img
                            :src="getImageUrl(selectedImage.current)"
                            :alt="showHoverImage ? selectedImage.hover_image_alt : selectedImage.main_image_alt || product.name"
                            class="h-[750px] w-full cursor-pointer object-cover transition-all duration-500"
                            @click="toggleImageView"
                            @error="handleImageError"
                        />
                        <!-- Image Type Indicator -->
                        <div class="absolute top-2 left-2 rounded-full bg-black/70 px-2 py-1 text-xs text-white">
                            {{ showHoverImage ? 'İkincil' : 'Ana' }} Resim
                        </div>
                        <!-- Toggle Button -->
                        <div v-if="selectedImage.hover_image" class="absolute right-2 bottom-2">
                            <button
                                @click="toggleImageView"
                                class="rounded-full bg-blue-600 p-2 text-white shadow-lg transition-colors hover:bg-blue-700"
                                :title="showHoverImage ? 'Ana resmi göster' : 'Hover resmi göster'"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- Image Navigation Info -->
                    <div v-if="selectedImage.hover_image" class="text-xs text-gray-500 dark:text-gray-400">
                        Resme tıklayarak ana ve ikincil görünümü arasında geçiş yapabilirsiniz
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import {
    InfoIcon,
    EditIcon,
    SettingsIcon,
    PaletteIcon,
    ImageIcon,
    CreditCardIcon
} from 'lucide-vue-next';
import { computed, onMounted, ref } from 'vue';

const showDebug = ref(false);
const selectedImageIndex = ref(0);
const showHoverImage = ref(false);
const isMobile = ref(false);
const isDark = ref(false);
const loadingMore = ref(false);
const allImages = ref([]);

const page = usePage();
const product = page.props.product;
const totalImagesCount = page.props.totalImagesCount;
const hasMoreImages = ref(page.props.hasMoreImages);

// Mobile detection
const checkMobile = () => {
    isMobile.value = window.innerWidth < 1024;
};

// Dark mode detection
const checkDarkMode = () => {
    isDark.value = document.documentElement.classList.contains('dark') || window.matchMedia('(prefers-color-scheme: dark)').matches;
};

// İlk yüklemede product.images'i allImages'e kopyala - DÜZELTME
onMounted(() => {
    // İlk olarak mevcut resimleri allImages'e kopyala
    allImages.value = [...product.images];

    checkMobile();
    checkDarkMode();

    // Event listeners
    window.addEventListener('resize', checkMobile);

    // Watch for dark mode changes
    const observer = new MutationObserver(checkDarkMode);

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class'],
    });

    // Media query listener for system dark mode
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', checkDarkMode);
});

const remainingImagesCount = computed(() => {
    return totalImagesCount - allImages.value.length;
});

// selectedImage computed'ını allImages kullanacak şekilde düzelt
const selectedImage = computed(() => {
    if (allImages.value && allImages.value.length > 0) {
        const image = allImages.value[selectedImageIndex.value] || allImages.value[0];
        return {
            current: showHoverImage.value && image.hover_image ? image.hover_image : image.main_image,
            main_image: image.main_image,
            hover_image: image.hover_image,
            main_image_alt: image.main_image_alt,
            hover_image_alt: image.hover_image_alt,
        };
    }
    return { current: '', main_image: '', hover_image: '', main_image_alt: '', hover_image_alt: '' };
});

const selectImage = (image: any, index: number) => {
    selectedImageIndex.value = index;
    showHoverImage.value = false;
};

const toggleImageView = () => {
    showHoverImage.value = !showHoverImage.value;
};

const formatPrice = (price: number | string) => {
    const numPrice = typeof price === 'string' ? parseFloat(price) : price;
    const basePrice = Math.round(numPrice / 1.2);
    const kdv = Math.round(numPrice - basePrice);
    const total = basePrice + kdv;
    return `${basePrice} + ${kdv} KDV = ${total} ₺`;
};

const handleImageError = (event: Event) => {
    const img = event.target as HTMLImageElement;
    img.src = '/placeholder.svg?height=400&width=400&text=Resim+Yüklenemedi';
};

// Yardımcı fonksiyon: path'i tam url'ye çevir
const getImageUrl = (path: string) => {
    if (!path) return ''
    if (path.startsWith('http')) return path
    return `/storage/${path}`
}

const loadMoreImages = async () => {
    if (loadingMore.value) return;

    loadingMore.value = true;

    try {
        const response = await axios.get(`/dashboard/pages/${product.id}/load-more-images`, {
            params: {
                offset: allImages.value.length,
                limit: 6,
            },
        });

        // Yeni resimleri mevcut listeye ekle
        allImages.value = [...allImages.value, ...response.data.images];
        hasMoreImages.value = response.data.hasMore;

        console.log('Yeni resimler yüklendi:', response.data.images);
        console.log('Toplam resim sayısı:', allImages.value.length);
    } catch (error) {
        console.error('Daha fazla resim yüklenirken hata:', error);
        alert('Resimler yüklenirken bir hata oluştu.');
    } finally {
        loadingMore.value = false;
    }
};
</script>

<style scoped>
/* Önceki CSS kodları aynı kalıyor */
.custom-scroll::-webkit-scrollbar {
    width: 6px;
}

.custom-scroll::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scroll::-webkit-scrollbar-thumb {
    background-color: #ff4a3b;
    border: none;
    border-radius: 3px;
}

.custom-scroll::-webkit-scrollbar-thumb:hover {
    background-color: #e53e3e;
}

.custom-scroll {
    scrollbar-width: thin;
    scrollbar-color: #ff4a3b transparent;
}

.dark .custom-scroll::-webkit-scrollbar-thumb {
    background-color: #ff6b5b;
}

.dark .custom-scroll::-webkit-scrollbar-thumb:hover {
    background-color: #ff4a3b;
}

.dark .custom-scroll {
    scrollbar-color: #ff6b5b transparent;
}

* {
    transition: all 0.2s ease-in-out;
}

.hover\:shadow-lg:hover {
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.1),
        0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.dark .hover\:shadow-lg:hover {
    box-shadow:
        0 10px 15px -3px rgba(0, 0, 0, 0.3),
        0 4px 6px -2px rgba(0, 0, 0, 0.2);
}

.dark .hover\:shadow-2xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:scale-\[1\.02\] {
    transform: scale(1.02);
}

@media (max-width: 640px) {
    .grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

@media (min-width: 641px) {
    .sm\:grid-cols-6 {
        grid-template-columns: repeat(6, minmax(0, 1fr));
    }
}

button:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

.dark button:focus {
    outline-color: #60a5fa;
}

.dark .shadow-sm {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
}

.dark .shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.ring-2 {
    box-shadow: 0 0 0 2px currentColor;
}
</style>
