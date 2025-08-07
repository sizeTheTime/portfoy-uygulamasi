<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageContainer>
            <div class="max-w-3xl mx-auto p-8">
                <SectionBox>
                    <div class="flex items-center justify-between mb-6">
                        <SectionHeader
                            :icon="ImageIcon"
                            title="Kart Bilgileri"
                            description="Ürün kartında görünecek bilgileri düzenleyin"
                        />
                        <Link
                            :href="`/dashboard/pages/${productId}`"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/20 rounded-lg text-gray-700 hover:text-gray-900 transition-all duration-200"
                        >
                            <ArrowLeft class="h-4 w-4" />
                            Geri Dön
                        </Link>
                    </div>

                    <!-- Success/Error Messages -->
                    <div v-if="message" class="mb-6">
                        <div
                            class="rounded-lg px-4 py-3 flex items-center"
                            :class="{
                                'border border-green-300 bg-green-50 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200': messageType === 'success',
                                'border border-red-300 bg-red-50 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200': messageType === 'error',
                            }"
                        >
                            <CheckCircle v-if="messageType === 'success'" class="h-5 w-5 mr-2 text-green-500" />
                            <AlertCircle v-else class="h-5 w-5 mr-2 text-red-500" />
                            {{ message }}
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="space-y-6">
                        <FormField
                            id="title"
                            label="Kart Başlığı *"
                            description="Ürün kartında görünecek başlık"
                            v-model="form.title"
                            placeholder="Kart başlığı"
                            :error="getError('title')"
                            type="text"
                        />

                        <FormTextareaField
                            id="description"
                            label="Kart Açıklaması"
                            description="Ürün kartında görünecek açıklama metni"
                            v-model="form.description"
                            :textareaProps="{ rows: 3, placeholder: 'Kart açıklaması' }"
                            :error="getError('description')"
                        />

                        <!-- Ana Resim Input ve Preview -->
                        <FormImageInput
                            v-model="form.main_image"
                            label="Ana Resim"
                            description="Kart için ana resim seçin"
                            :error="getError('main_image')"
                            @file-select="handleFileSelect($event, 'main_image')"
                        />
                        <div v-if="card.main_image" class="mb-4">
                            <img :src="card.main_image" alt="Ana Resim Önizleme" class="w-32 h-32 object-cover rounded border" />
                        </div>

                        <FormField
                            id="main_image_alt"
                            label="Ana Resim Alt Text"
                            description="Ana resim için alt metin (SEO için önemli)"
                            v-model="form.main_image_alt"
                            placeholder="Ana resim alt text"
                            :error="getError('main_image_alt')"
                            type="text"
                        />

                        <!-- İkinci Resim Input ve Preview -->
                        <FormImageInput
                            v-model="form.secondary_image"
                            label="İkinci Resim"
                            description="Kart için ikinci resim seçin"
                            :error="getError('secondary_image')"
                            @file-select="handleFileSelect($event, 'secondary_image')"
                        />
                        <div v-if="card.secondary_image" class="mb-4">
                            <img :src="card.secondary_image" alt="İkinci Resim Önizleme" class="w-32 h-32 object-cover rounded border" />
                        </div>

                        <FormField
                            id="secondary_image_alt"
                            label="İkinci Resim Alt Text"
                            description="İkinci resim için alt metin (SEO için önemli)"
                            v-model="form.secondary_image_alt"
                            placeholder="İkinci resim alt text"
                            :error="getError('secondary_image_alt')"
                            type="text"
                        />

                        <!-- Custom Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <Link
                                :href="`/dashboard/pages/${productId}`"
                                class="inline-flex items-center gap-2 px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 rounded-lg transition-all duration-200 font-medium"
                            >
                                <ArrowLeft class="h-4 w-4" />
                                Geri Gel
                            </Link>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white rounded-lg transition-all duration-200 font-medium disabled:cursor-not-allowed"
                            >
                                <template v-if="form.processing">
                                    <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                                    Kaydediliyor...
                                </template>
                                <template v-else>
                                    <CheckCircle class="h-4 w-4" />
                                    Kaydet
                                </template>
                            </button>
                        </div>
                    </form>
                </SectionBox>
            </div>
        </PageContainer>
    </AppLayout>
</template>

<script setup lang="ts">
import { FormField, FormImageInput, FormTextareaField } from '@/components/ui/input'
import { PageContainer } from '@/components/ui/layout'
import { SectionBox, SectionHeader } from '@/components/ui/section'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm, usePage, Link } from '@inertiajs/vue3'
import { Image as ImageIcon, CheckCircle, AlertCircle, ArrowLeft } from 'lucide-vue-next'
import { ref } from 'vue'

// Breadcrumbs
const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Ürünler', href: '/dashboard/pages' },
    { title: 'Kart Bilgileri', href: '#' },
]

// Props from controller
const page = usePage()
const card = page.props.card ?? {}
const productId = page.props.product_id

const message = ref('')
const messageType = ref<'success' | 'error' | ''>('')

// form başlatma kısmı
const form = useForm({
    main_image: null,
    secondary_image: null, // sadece dosya olmalı
    main_image_alt: card.main_image_alt ?? '',
    secondary_image_alt: card.secondary_image_alt ?? '',
    title: card.title ?? '',
    description: card.description ?? '',
})

// Hata getter
const getError = (field: string) => form.errors[field]

// Dosya seçme
const handleFileSelect = (event: Event, field: string) => {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0]
    if (file) {
        form[field] = file
    }
}

// Form gönderme
const submit = () => {
    form.post(`/dashboard/pages/${productId}/edit/card`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            message.value = 'Kart bilgileri başarıyla güncellendi.'
            messageType.value = 'success'
            // Sadece props'u güncelle
            window.location.reload()
        },
        onError: () => {
            message.value = 'Bir hata oluştu. Lütfen tekrar deneyin.'
            messageType.value = 'error'
        },
    })
}
</script>

<style scoped>
/* Buraya stil kodları eklenecek */
</style>
