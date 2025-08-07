<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageContainer>
            <div class="max-w-6xl mx-auto p-8">
                <SectionBox>

                    <!-- Real Time Image Gallery -->
                    <RealTimeImageGallery
                        :product-id="productId"
                        :initial-images="initialImages"
                        @images-updated="handleImagesUpdated"
                    />

                    <!-- Back Button -->
                    <div class="mt-8 flex justify-center">
                        <button
                            type="button"
                            @click="$inertia.visit(`/dashboard/pages/${productId}`)"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-gray-700"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Ürün Detayına Dön
                        </button>
                    </div>
                </SectionBox>
            </div>
        </PageContainer>
    </AppLayout>
</template>

<script setup lang="ts">
import { PageContainer } from '@/components/ui/layout'
import { SectionBox, SectionHeader } from '@/components/ui/section'
import RealTimeImageGallery from '@/components/ui/input/RealTimeImageGallery.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { Image as ImageIcon, ArrowLeft } from 'lucide-vue-next'

// Breadcrumbs
const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Ürünler', href: '/dashboard/pages' },
    { title: 'Galeri Düzenle', href: '#' },
]

// Props from controller
const page = usePage()
const productId = page.props.product_id
const initialImages = page.props.images || []

// Handle images updated event
const handleImagesUpdated = (images: any[]) => {
    console.log('Galeri güncellendi:', images)
    // Burada gerekirse başka işlemler yapılabilir
}
</script>
