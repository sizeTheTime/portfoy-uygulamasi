<template>
    <AppLayout>
        <Head title="Blog Görseli Düzenle" />

        <div class="mx-auto mt-10 max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <button
                            @click="goToBlogDetails"
                            class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors mb-4"
                        >
                            <ArrowLeft class="mr-2 h-4 w-4" />
                            Blog Detayına Dön
                        </button>

                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Blog Görseli Düzenle
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            "{{ blog.title }}" için öne çıkan görseli düzenleyin
                        </p>
                    </div>
                </div>
            </div>

            <AlertMessage :message="message" :type="messageType" />

            <form @submit.prevent="submit" class="space-y-8">
                <!-- Mevcut Görsel Bilgileri -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                        <Info class="mr-2 h-5 w-5" />
                        Mevcut Görsel Bilgileri
                    </h2>

                    <div v-if="blog.featured_image" class="space-y-4">
                        <!-- Mevcut Görsel Önizleme -->
                        <div class="relative">
                            <img
                                :src="blog.featured_image"
                                :alt="blog.featured_image_alt || blog.title"
                                class="w-full rounded-lg max-h-96 object-cover"
                            />
                            <div class="absolute top-2 right-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                    <CheckCircle class="mr-1 h-3 w-3" />
                                    Mevcut Görsel
                                </span>
                            </div>
                        </div>

                        <!-- Mevcut Alt Text -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mevcut Alt Text
                            </label>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ blog.featured_image_alt || 'Alt text belirtilmemiş' }}
                            </p>
                        </div>

                        <!-- Görsel URL -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Görsel URL
                            </label>
                            <p class="text-xs text-gray-500 dark:text-gray-400 break-all font-mono">
                                {{ blog.featured_image }}
                            </p>
                        </div>
                    </div>

                    <div v-else class="text-center py-8">
                        <ImageIcon class="h-16 w-16 text-gray-400 mx-auto mb-4" />
                        <p class="text-gray-500 dark:text-gray-400">Bu blog için henüz öne çıkan görsel yüklenmemiş</p>
                    </div>
                </div>

                <!-- Görsel Düzenleme Formu -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                        <Edit class="mr-2 h-5 w-5" />
                        Görsel Düzenleme
                    </h2>

                    <div class="space-y-6">
                            <ImageUpload
                                :modelValue="featuredImageUrl"
                                :altText="form.featured_image_alt"
                                @update:modelValue="handleImageUpdate"
                                @update:altText="(val) => (form.featured_image_alt = val)"
                                :error="form.errors.featured_image"
                                :altError="form.errors.featured_image_alt"
                                label="Görsel Dosyası"
                                description="Blog için öne çıkan görsel seçin"
                                required
                            />

                    </div>
                </div>

                <!-- Form Butonları -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <button
                        type="button"
                        @click="goToBlogDetails"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                    >
                        <X class="mr-2 h-4 w-4" />
                        İptal
                    </button>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white rounded-lg transition-colors"
                    >
                        <span v-if="form.processing" class="mr-2 h-4 w-4 animate-spin rounded-full border-t-2 border-white"></span>
                        <Save v-else class="mr-2 h-4 w-4" />
                        {{ form.remove_featured_image ? 'Görseli Kaldır' : 'Değişiklikleri Kaydet' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { FormField, ImageUpload } from '@/components/ui/input';
import { AlertMessage } from '@/components/ui/alert';
import {
    ArrowLeft,
    Info,
    Edit,
    Save,
    X,
    CheckCircle,
    ImageIcon,
    AlertTriangle
} from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

// Props
const props = defineProps({
    blog: {
        type: Object,
        required: true
    }
});

const message = ref('');
const messageType = ref('');

// Form
const form = useForm({
    featured_image: null, // Sadece yeni dosya seçilirse File olur
    featured_image_alt: props.blog.featured_image_alt || '',
});

// Methods
const submit = () => {
form.post(`/dashboard/blogs/${props.blog.id}/update-image`, {
    forceFormData: true,
    onSuccess: () => {
        message.value = 'Görsel başarıyla güncellendi!';
        messageType.value = 'success';
    },
    onError: () => {
        message.value = 'Hata oluştu, lütfen formu kontrol edin.';
        messageType.value = 'error';
    },
});
};

const goToBlogDetails = () => {
    router.visit(`/dashboard/blogs/${props.blog.id}`);
};

const handleImageUpdate = (file) => {
    form.featured_image = file;
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
