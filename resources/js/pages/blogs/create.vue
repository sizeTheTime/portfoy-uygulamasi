<template>
    <AppLayout>
        <Head title="Yeni Blog Oluştur" />
        <div class="mx-auto mt-10 max-w-8xl px-4 sm:px-6 lg:px-8">
            <AlertMessage :message="message" :type="messageType" />

            <form @submit.prevent="submit" class="space-y-8">
                <FormGrid>
                    <!-- Sol Kolon - Ana Form -->
                    <ColSpan>
                        <!-- Temel Bilgiler Kartı -->
                        <SectionBox>
                            <SectionHeader title="Temel Bilgiler" description="Blog yazınızın başlığı, slug'ı ve kısa özetini girin." :icon="Info" />
                            <div class="space-y-6">
                                <FormField
                                    id="title"
                                    label="Blog Başlığı *"
                                    v-model="form.title"
                                    :error="form.errors.title"
                                    placeholder="Etkileyici blog başlığınızı buraya yazın..."
                                    type="text"
                                />

                                <FormField
                                    id="slug"
                                    label="URL Slug"
                                    v-model="form.slug"
                                    :error="form.errors.slug"
                                    placeholder="blog-url-slug"
                                    type="text"
                                />

                                <FormTextareaField
                                    id="excerpt"
                                    label="Blog Özeti *"
                                    description="Blog yazınızın kısa ve çekici özetini yazın"
                                    v-model="form.excerpt"
                                    :error="form.errors.excerpt"
                                    placeholder="Blog yazınızın kısa ve çekici özetini buraya yazın..."
                                    :textareaProps="{ rows: 3 }"
                                />
                            </div>
                        </SectionBox>

                        <!-- İçerik Tipi Seçimi -->
                        <SectionBox>
                            <SectionHeader title="İçerik Tipi" description="Blog içeriğinizi nasıl oluşturmak istediğinizi seçin." :icon="Settings" />
                            <div class="space-y-4">
                                <div class="flex gap-4">
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input
                                            type="radio"
                                            v-model="form.content_type"
                                            value="tiptap"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                        <div class="flex items-center space-x-2">
                                            <Edit class="w-5 h-5 text-blue-600" />
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Rich Text Editör (Tiptap)</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input
                                            type="radio"
                                            v-model="form.content_type"
                                            value="html"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        />
                                        <div class="flex items-center space-x-2">
                                            <Code class="w-5 h-5 text-green-600" />
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Düz HTML Kodu</span>
                                        </div>
                                    </label>
                                </div>
                                <p v-if="form.errors.content_type" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.content_type }}</p>
                            </div>
                        </SectionBox>

                        <!-- Blog İçeriği Kartı -->
                        <SectionBox>
                            <SectionHeader
                                :title="form.content_type === 'html' ? 'HTML İçeriği' : 'Blog İçeriği'"
                                :description="form.content_type === 'html' ? 'Özelleştirilmiş HTML kodunuzu buraya girin.' : 'Blog yazınızın ana içeriğini buraya girin.'"
                                :icon="form.content_type === 'html' ? Code : Edit"
                            />

                            <!-- Tiptap Editor -->
                            <TiptapEditor
                                v-if="form.content_type === 'tiptap'"
                                v-model="form.content"
                                :error="form.errors.content"
                                placeholder="Blog içeriğinizi buraya yazın..."
                            />

                            <!-- HTML Textarea -->
                            <div v-else-if="form.content_type === 'html'" class="space-y-2">
                                <textarea
                                    v-model="form.content"
                                    rows="20"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white font-mono text-sm"
                                    placeholder="HTML kodunuzu buraya yazın...

Örnek:
<div class='custom-blog-layout'>
  <h1>Özel Başlık</h1>
  <p>İçerik...</p>
</div>"
                                ></textarea>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>HTML, CSS ve JavaScript kodları desteklenir</span>
                                    <span>{{ form.content?.length || 0 }} karakter</span>
                                </div>
                                <p v-if="form.errors.content" class="text-sm text-red-600 dark:text-red-400">{{ form.errors.content }}</p>
                            </div>

                            <!-- İçerik Tipi Seçilmemişse -->
                            <div v-else class="flex items-center justify-center h-32 bg-gray-50 dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
                                <div class="text-center">
                                    <Settings class="w-8 h-8 text-gray-400 mx-auto mb-2" />
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Önce içerik tipini seçin</p>
                                </div>
                            </div>
                        </SectionBox>
                    </ColSpan>

                    <ColSpan :span="'col-span-2 space-y-6'">
                        <!-- Sağ Kolon - Yan Panel -->
                        <!-- Yayın Ayarları -->
                        <SectionBox>
                            <SectionHeader title="Yayın Ayarları" description="Blogun hangi tarihte ve saatte yayınlanacağını seçin." :icon="Info" />
                            <FormField
                                id="published_at"
                                label="Yayın Tarihi"
                                description="Blogun hangi tarihte ve saatte yayınlanacağını seçin"
                                v-model="form.published_at"
                                :error="form.errors.published_at"
                                type="datetime-local"
                                :inputProps="{
                                    class: 'block w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 text-sm',
                                }"
                            />
                        </SectionBox>
                        <!-- Öne Çıkan Görsel -->
                        <SectionBox>
                            <SectionHeader
                                title="Öne Çıkan Görsel"
                                description="Blog yazınız için öne çıkan görseli ve alt metnini ekleyin. Bu görsel blog kartında ve paylaşımda kullanılacaktır."
                                :icon="Info"
                            />
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
                        </SectionBox>
                        <!-- SEO Ayarları -->
                        <SectionBox>
                            <SectionHeader
                                title="SEO Ayarları"
                                description="Arama motorlarında blogunuzun daha iyi görünmesi için meta başlık, açıklama ve anahtar kelimeleri girin."
                                :icon="Info"
                            />
                            <FormField
                                id="meta_title"
                                label="Meta Title"
                                description="Sayfa başlığı (SEO için önemli)"
                                v-model="form.meta_title"
                                :error="form.errors.meta_title"
                                type="text"
                            />
                            <FormTextareaField
                                id="meta_description"
                                label="Meta Description"
                                description="Arama motorları için blogunuzu özetleyen kısa bir açıklama girin"
                                v-model="form.meta_description"
                                :error="form.errors.meta_description"
                                placeholder="Meta açıklamanızı girin..."
                                :textareaProps="{ rows: 3 }"
                            />
                            <FormField
                                id="meta_keywords"
                                label="Meta Keywords"
                                description="Virgül ile ayırarak anahtar kelimeleri girin"
                                v-model="form.meta_keywords"
                                :error="form.errors.meta_keywords"
                                type="text"
                                placeholder="kelime1, kelime2, kelime3"
                            />
                        <FormField
                            id="canonical_url"
                            label="Canonical URL"
                            description="Sayfanın kanonik (asıl) URL'si"
                            v-model="form.canonical_url"
                            :error="form.errors.canonical_url"
                            type="text"
                        />
                        </SectionBox>
                    </ColSpan>
                </FormGrid>
                <!-- Form Butonları -->
                <div
                    class="flex flex-col gap-6 rounded-2xl border bg-white/80 p-8 shadow-xl lg:flex-row lg:items-center lg:justify-between dark:bg-gray-800/80"
                >
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <button
                            type="button"
                            @click="$inertia.visit('/dashboard/blogs')"
                            class="inline-flex transform items-center justify-center rounded-xl bg-gradient-to-r from-gray-100 to-gray-200 px-8 py-4 font-semibold text-gray-700 shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:from-gray-200 hover:to-gray-300 hover:shadow-xl dark:from-gray-600 dark:to-gray-700 dark:text-gray-300 dark:hover:from-gray-500 dark:hover:to-gray-600"
                        >
                            <ArrowLeft class="mr-2 h-5 w-5" /> İptal
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex transform items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-4 font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl dark:from-blue-700 dark:to-purple-700 dark:hover:from-blue-600 dark:hover:to-purple-600"
                        >
                            <span v-if="form.processing" class="mr-2 h-4 w-4 animate-spin rounded-full border-t-2 border-white"></span>
                            Blog Yayınla
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { ColSpan, FormGrid } from '@/components/ui/grid';
import { FormField, FormTextareaField, ImageUpload, TiptapEditor } from '@/components/ui/input';
import { SectionBox, SectionHeader } from '@/components/ui/section';
import { ArrowLeft, Info, Settings, Edit, Code } from 'lucide-vue-next';
import {AlertMessage} from '@/components/ui/alert';

const message = ref('');
const messageType = ref('');

// Türkçe karakterleri ve özel harfleri düzgün slug'a çeviren fonksiyon
const createSlug = (text) => {
    return text
        .toLowerCase()
        .replace(/ç/g, 'c')
        .replace(/ğ/g, 'g')
        .replace(/ı/g, 'i')
        .replace(/ö/g, 'o')
        .replace(/ş/g, 's')
        .replace(/ü/g, 'u')
        .replace(/[^a-z0-9\s-]/g, '') // Türkçe harfler dönüştürüldü, özel karakterleri kaldır
        .replace(/\s+/g, '-') // Boşlukları tire ile değiştir
        .replace(/-+/g, '-') // Çoklu tireleri tek tire yap
        .replace(/^-+|-+$/g, ''); // Başta ve sonda tire varsa kaldır
};

const form = useForm({
    title: '',
    slug: '',
    excerpt: '',
    content: '',
    content_type: 'tiptap', // Varsayılan olarak tiptap
    featured_image: null,
    featured_image_alt: '',
    published_at: '',
    meta_title: '',
    meta_description: '',
    meta_keywords: '',
    canonical_url: '',
});

// Title değişikliklerini izle ve slug + canonical URL'yi güncelle
watch(() => form.title, (newTitle) => {
    if (newTitle) {
        const slug = createSlug(newTitle);
        form.slug = slug;
        form.canonical_url = `/yazilarimiz/${slug}`;
    } else {
        form.slug = '';
        form.canonical_url = '';
    }
}, { immediate: false });

// ImageUpload component'i için URL string döndüren computed
const featuredImageUrl = computed(() => {
    if (form.featured_image && typeof form.featured_image !== 'string') {
        return URL.createObjectURL(form.featured_image);
    }
    return form.featured_image; // null veya string URL
});

// ImageUpload'dan gelen File'ı handle eden method
const handleImageUpdate = (file) => {
    form.featured_image = file;
};

const submit = () => {
    form.post('/dashboard/blogs', {
        forceFormData: true,
        onSuccess: () => {
            message.value = 'Blog başarıyla oluşturuldu!';
            messageType.value = 'success';
            form.reset();
        },
        onError: () => {
            message.value = 'Hata oluştu, lütfen formu kontrol edin.';
            messageType.value = 'error';
        },
    });
};
</script>

<style>
/* global.css veya ilgili stil dosyanıza ekleyin */
input[type='datetime-local']::-webkit-calendar-picker-indicator {
    filter: invert(1); /* dark mode için ikon rengini ters çevirir */
}
</style>
