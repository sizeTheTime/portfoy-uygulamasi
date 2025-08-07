<template>
    <AppLayout>

        <div class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-8">
                <button
                    @click="$inertia.visit('/dashboard/blogs')"
                    class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors"
                >
                    <ArrowLeft class="mr-2 h-4 w-4" />
                    Blog Listesine Dön
                </button>
            </div>

            <!-- Blog Header -->
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    {{ blog.title }}
                </h1>

                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-6">
                    <div class="flex items-center gap-1">
                        <Calendar class="h-4 w-4" />
                        <span>{{ formatDate(blog.published_at || blog.created_at) }}</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <Clock class="h-4 w-4" />
                        <span>{{ estimatedReadingTime }} dakika okuma</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <component :is="blog.content_type === 'html' ? Code : Edit" class="h-4 w-4" />
                        <span>{{ blog.content_type === 'html' ? 'HTML İçerik' : 'Rich Text' }}</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <component :is="isPublished ? CheckCircle : Clock" class="h-4 w-4" />
                        <span :class="isPublished ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400'">
                            {{ isPublished ? 'Yayında' : 'Taslak' }}
                        </span>
                    </div>
                </div>

            </header>

            <!-- Featured Image -->
            <div v-if="blog.featured_image" class="mb-8">
                <div class="relative overflow-hidden rounded-xl shadow-lg">
                    <img
                        :src="blog.featured_image"
                        :alt="blog.featured_image_alt || blog.title"
                        class="w-full h-auto max-h-96 object-cover"
                    />
                    <div v-if="blog.featured_image_alt" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                        <p class="text-white text-sm">{{ blog.featured_image_alt }}</p>
                    </div>
                </div>
            </div>

            <!-- Blog Excerpt -->
            <div v-if="blog.excerpt" class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Özet</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ blog.excerpt }}
                </p>
            </div>
            <!-- Blog Content -->
            <article class="prose prose-lg max-w-none dark:prose-invert">
                <!-- Tiptap Content -->
                <div
                    v-if="blog.content_type === 'tiptap'"
                    class="tiptap-editor"
                    v-html="blog.content"
                ></div>

                <!-- HTML Content -->
                <div
                    v-else-if="blog.content_type === 'html'"
                    class="html-content"
                    v-html="blog.content"
                ></div>

                <!-- Fallback -->
                <div v-else class="text-center py-8">
                    <FileText class="h-12 w-12 text-gray-400 mx-auto mb-4" />
                    <p class="text-gray-500 dark:text-gray-400">İçerik bulunamadı</p>
                </div>
            </article>



        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    ArrowLeft,
    Calendar,
    Clock,
    Edit,
    Code,
    CheckCircle,
    FileText,
    ExternalLink,
    Trash2
} from 'lucide-vue-next';

// Props
const props = defineProps({
    blog: {
        type: Object,
        required: true
    }
});

// Computed Properties
const isPublished = computed(() => {
    if (!props.blog.published_at) return false;
    return new Date(props.blog.published_at) <= new Date();
});

const estimatedReadingTime = computed(() => {
    if (!props.blog.content) return 1;
    const wordsPerMinute = 200;
    const wordCount = props.blog.content.replace(/<[^>]*>/g, '').split(/\s+/).length;
    return Math.max(1, Math.ceil(wordCount / wordsPerMinute));
});

// Methods
const formatDate = (dateString) => {
    if (!dateString) return 'Tarih belirtilmemiş';
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const viewPublicBlog = () => {
    if (props.blog.slug) {
        window.open(`/blogs/${props.blog.slug}`, '_blank');
    }
};

const deleteBlog = () => {
    if (confirm(`"${props.blog.title}" başlıklı blog yazısını silmek istediğinizden emin misiniz?`)) {
        // Delete işlemi için Inertia kullanın
        // $inertia.delete(`/dashboard/blogs/${props.blog.id}`);
        console.log('Blog siliniyor:', props.blog.id);
    }
};
</script>

<style scoped>
/* Prose styling for content */

</style>
