<template>
    <AppLayout>
        <Head title="Blog Yönetimi" />

        <div class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Blog Yönetimi</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Toplam {{ blogs.total }} blog yazısı bulunuyor
                    </p>
                </div>
                <div class="flex gap-3">
                    <button
                        @click="$inertia.visit('/dashboard/blogs/create')"
                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-3 font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl"
                    >
                        <Plus class="mr-2 h-5 w-5" />
                        Yeni Blog
                    </button>
                </div>
            </div>

            <!-- Blog Cards Grid -->
            <div v-if="blogs.data.length > 0" class="space-y-6">
                <!-- Cards Grid -->
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 items-stretch">
                    <div
                        v-for="blog in blogs.data"
                        :key="blog.id"
                        class="group relative overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-gray-800 h-full flex flex-col"
                    >
                        <!-- Featured Image -->
                        <div class="relative h-48 overflow-hidden">
                            <img
                                v-if="blog.featured_image"
                                :src="blog.featured_image"
                                :alt="blog.featured_image_alt || blog.title"
                                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800"
                            >
                                <ImageIcon class="h-12 w-12 text-gray-400 dark:text-gray-500" />
                            </div>

                            <!-- Content Type Badge -->
                            <div class="absolute top-3 left-3">
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                        blog.content_type === 'html'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400'
                                            : 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400'
                                    ]"
                                >
                                    <component
                                        :is="blog.content_type === 'html' ? Code : Edit"
                                        class="mr-1 h-3 w-3"
                                    />
                                    {{ blog.content_type === 'html' ? 'HTML' : 'Rich Text' }}
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                <span
                                    :class="[
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                        isPublished(blog.published_at)
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400'
                                            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400'
                                    ]"
                                >
                                    <component
                                        :is="isPublished(blog.published_at) ? CheckCircle : Clock"
                                        class="mr-1 h-3 w-3"
                                    />
                                    {{ isPublished(blog.published_at) ? 'Yayında' : 'Taslak' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 flex-1 flex flex-col">
                            <!-- Title -->
                            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white line-clamp-2">
                                {{ blog.title }}
                            </h3>

                            <!-- Excerpt -->
                            <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 line-clamp-3 flex-1">
                                {{ blog.excerpt }}
                            </p>

                            <!-- Meta Info -->
                            <div class="mb-4 flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    <Calendar class="h-3 w-3" />
                                    {{ formatDate(blog.created_at) }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <Eye class="h-3 w-3" />
                                    {{ blog.views || 0 }} görüntüleme
                                </div>
                            </div>

                            <!-- Slug - Alt kısma sabitlendi -->
                            <div class="mb-4 rounded-lg bg-gray-50 px-3 py-2 dark:bg-gray-700 mt-auto">
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <span class="font-medium">URL:</span>
                                    <span class="font-mono">/blogs/{{ blog.slug }}</span>
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex gap-2">
                                    <!-- View Button -->
                                    <button
                                        @click="viewBlog(blog)"
                                        class="inline-flex items-center rounded-lg bg-gray-100 px-3 py-2 text-xs font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                                        title="Görüntüle"
                                    >
                                        <Eye class="h-5 w-5" />
                                    </button>

                                    <!-- Edit Button -->
                                    <Link
                                        :href="`/dashboard/blogs/${blog.id}/edit`"
                                        class="inline-flex items-center rounded-lg bg-blue-100 px-3 py-2 text-xs font-medium text-blue-700 transition-colors hover:bg-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30"
                                        title="Düzenle"
                                    >
                                        <Edit class="h-5 w-5" />
                                    </Link>

                                    <!-- Image Edit Button -->
                                    <Link
                                        :href="`/dashboard/blogs/${blog.id}/update-image`"
                                        class="inline-flex items-center rounded-lg bg-purple-100 px-3 py-2 text-xs font-medium text-purple-700 transition-colors hover:bg-purple-200 dark:bg-purple-900/20 dark:text-purple-400 dark:hover:bg-purple-900/30"
                                        title="Görsel Düzenle"
                                    >
                                        <ImageIcon class="h-5 w-5" />
                                    </Link>
                                </div>

                                <!-- Delete Button -->
                                <button
                                    @click="openDeleteModal(blog)"
                                    class="inline-flex items-center rounded-lg bg-red-100 px-3 py-2 text-xs font-medium text-red-700 transition-colors hover:bg-red-200 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30"
                                    title="Sil"
                                >
                                    <Trash2 class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="blogs.last_page > 1" class="mt-8">
                    <nav class="flex items-center justify-center space-x-2">
                        <!-- Previous Button -->
                        <button
                            v-if="blogs.prev_page_url"
                            @click="$inertia.visit(blogs.prev_page_url)"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
                        >
                            <ChevronLeft class="mr-1 h-4 w-4" />
                            Önceki
                        </button>

                        <!-- Page Numbers -->
                        <div class="flex space-x-1">
                            <button
                                v-for="page in paginationPages"
                                :key="page"
                                @click="goToPage(page)"
                                :class="[
                                    'inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium',
                                    page === blogs.current_page
                                        ? 'bg-blue-600 text-white'
                                        : 'border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'
                                ]"
                            >
                                {{ page }}
                            </button>
                        </div>

                        <!-- Next Button -->
                        <button
                            v-if="blogs.next_page_url"
                            @click="$inertia.visit(blogs.next_page_url)"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
                        >
                            Sonraki
                            <ChevronRight class="ml-1 h-4 w-4" />
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="flex flex-col items-center justify-center py-16">
                <div class="mb-6 rounded-full bg-gray-100 p-6 dark:bg-gray-800">
                    <FileText class="h-12 w-12 text-gray-400" />
                </div>
                <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">
                    Henüz blog yazısı yok
                </h3>
                <p class="mb-6 text-center text-gray-600 dark:text-gray-400">
                    İlk blog yazınızı oluşturarak başlayın
                </p>
                <button
                    @click="$inertia.visit('/dashboard/blogs/create')"
                    class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-3 font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl"
                >
                    <Plus class="mr-2 h-5 w-5" />
                    İlk Blog Yazınızı Oluşturun
                </button>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <DeleteConfirmModal
            :isOpen="deleteModal.isOpen"
            :blogTitle="deleteModal.blogTitle"
            :blogId="deleteModal.blogId"
            @close="closeDeleteModal"
            @confirm="handleDeleteConfirm"
        />
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';
import {
    Plus,
    Edit,
    Eye,
    Trash2,
    Calendar,
    Clock,
    CheckCircle,
    Code,
    ImageIcon,
    FileText,
    ChevronLeft,
    ChevronRight
} from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';
import DeleteConfirmModal from '@/components/ui/modal/DeleteConfirmModal.vue';

// Props
const props = defineProps({
    blogs: {
        type: Object,
        required: true
    }
});

// Delete modal state
const deleteModal = reactive({
    isOpen: false,
    blogId: null,
    blogTitle: ''
});

// Methods
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('tr-TR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

const isPublished = (publishedAt) => {
    if (!publishedAt) return false;
    return new Date(publishedAt) <= new Date();
};

const viewBlog = (blog) => {
    window.open(`/yazilarimiz/${blog.slug}`, '_blank');
};

const openDeleteModal = (blog) => {
    deleteModal.isOpen = true;
    deleteModal.blogId = blog.id;
    deleteModal.blogTitle = blog.title;
};

const closeDeleteModal = () => {
    deleteModal.isOpen = false;
    deleteModal.blogId = null;
    deleteModal.blogTitle = '';
};

const handleDeleteConfirm = async (blogId) => {
    try {
        await window.$inertia.delete(`/dashboard/blogs/${blogId}`, {
            onSuccess: () => {
                closeDeleteModal();
                // Başarı mesajı gösterilebilir
            },
            onError: (errors) => {
                console.error('Silme hatası:', errors);
                // Hata mesajı gösterilebilir
            }
        });
    } catch (error) {
        console.error('Silme işlemi başarısız:', error);
    }
};

const goToPage = (page) => {
    if (page !== props.blogs.current_page) {
        window.location.href = `?page=${page}`;
    }
};

// Computed
const paginationPages = computed(() => {
    const pages = [];
    const current = props.blogs.current_page;
    const last = props.blogs.last_page;

    // Basit pagination logic
    const start = Math.max(1, current - 2);
    const end = Math.min(last, current + 2);

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }

    return pages;
});
</script>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
