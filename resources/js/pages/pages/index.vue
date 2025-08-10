<script setup lang="ts">
import { PageContainer } from '@/components/ui/layout';
import { SectionHeader } from '@/components/ui/section';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { AlignLeft, ShoppingCart, Info } from 'lucide-vue-next';
import { computed } from 'vue';

interface CardImage {
    id: number;
    product_id: number;
    title: string;
    main_image: string;
    secondary_image: string;
    main_image_alt: string;
    secondary_image_alt: string;
    description: string;
    sort_order: number;
    created_at: string;
    updated_at: string;
}

interface Product {
    id: number;
    category_id: number;
    name: string;
    slug: string;
    description: string;
    short_description: string;
    price: string;
    sort_order: number;
    meta_title: string;
    meta_description: string;
    meta_keywords: string;
    canonical_url: string;
    created_at: string;
    updated_at: string;
    card_image: CardImage;
}

const page = usePage();
const products = computed<Product[]>(() => (page.props.products as Product[]) || []);

// Methods
const formatPrice = (price: string) => {
    return new Intl.NumberFormat('tr-TR', {
        style: 'currency',
        currency: 'TRY',
    }).format(parseFloat(price));
};

const getImageUrl = (imagePath: string) => {
    return `/storage/${imagePath}`;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Sayfalar',
        href: '/dashboard/pages',
    },
];
</script>

<template>
    <Head title="Sayfalar" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageContainer>
            <div class="mx-auto max-w-6xl p-2 md:p-8">
            <div class="flex flex-col-reverse md:flex-row items-center justify-between">
                <SectionHeader
                    :icon="Info"
                    title="Ürün Sayfaları"
                    description="Ürün sayfaları hakkında detaylı bilgileri inelemek için sayfaları görüntüleyin"
                />
                <Link
                    href="/dashboard/pages/create"
                    class="group light:from-gray-600 light:to-green-500 light:hover:from-gray-700 light:hover:to-green-400 light:focus:ring-offset-white inline-flex transform items-center gap-2 rounded-lg bg-gradient-to-r from-gray-800 to-green-700 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:from-gray-900 hover:to-green-600 hover:shadow-xl focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-900 focus:outline-none dark:from-gray-800 dark:to-green-700 dark:hover:from-gray-900 dark:hover:to-green-600 dark:focus:ring-offset-gray-900"
                >
                    <AlignLeft class="h-4 w-4" />
                    Yeni Sayfa Oluştur
                </Link>
            </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 gap-4 md:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:border-gray-200 hover:shadow-xl dark:border-gray-700 dark:bg-gray-800 dark:hover:border-gray-600"
                    >
                        <!-- Image Container -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-700">
                            <!-- Main Image -->
                            <img
                                :src="getImageUrl(product.card_image.main_image)"
                                :alt="product.card_image.main_image_alt"
                                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-110"
                                loading="lazy"
                            />

                            <!-- Secondary Image (Hover Effect) -->
                            <img
                                v-if="product.card_image.secondary_image"
                                :src="getImageUrl(product.card_image.secondary_image)"
                                :alt="product.card_image.secondary_image_alt"
                                class="absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                                loading="lazy"
                            />

                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black/0 transition-all duration-300 group-hover:bg-black/20"></div>

                            <!-- Price Badge -->
                            <div class="absolute top-4 left-4">
                                <div
                                    class="rounded-full bg-gradient-to-r from-blue-600 to-blue-700 px-3 py-1.5 text-sm font-semibold text-white shadow-lg"
                                >
                                    {{ formatPrice(product.price) }}
                                </div>
                            </div>

                            <!-- Title Overlay -->
                            <div class="absolute bottom-0 w-full bg-gray-800/50">
                                <h3 class="mb-2 line-clamp-1 p-4 text-lg text-white drop-shadow-lg">
                                    {{ product.card_image.title }}
                                </h3>
                            </div>

                            <!-- Quick Add to Cart -->
                            <div
                                class="absolute right-4 bottom-4 left-4 translate-y-2 transform opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100"
                            >
                                <Link
                                    :href="`/dashboard/pages/${product.id}`"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-green-700 px-4 py-2.5 font-medium text-white shadow-lg transition-all duration-200 hover:from-green-700 hover:to-green-800 hover:shadow-xl"
                                >
                                    <AlignLeft class="h-4 w-4" />
                                    Sayfayı Görüntüle
                                </Link>
                            </div>
                        </div>

                        <!-- Hover Border Effect -->
                        <div
                            class="pointer-events-none absolute inset-0 rounded-2xl border-2 border-transparent transition-all duration-300 group-hover:border-blue-200 dark:group-hover:border-blue-800"
                        ></div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="products.length === 0" class="py-16 text-center">
                    <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                        <ShoppingCart class="h-12 w-12 text-gray-400" />
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Henüz ürün bulunmuyor</h3>
                    <p class="mx-auto max-w-md text-gray-600 dark:text-gray-400">
                        Şu anda görüntülenecek ürün bulunmamaktadır. Lütfen daha sonra tekrar kontrol edin.
                    </p>
                </div>
            </div>
        </PageContainer>
    </AppLayout>
</template>
