<script setup lang="ts">
import AlertMessage from '@/components/ui/alert/AlertMessage.vue';
import { PageContainer } from '@/components/ui/layout';
import DataTable from '@/components/ui/table/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';

import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Plus, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Kategoriler',
        href: '/categories',
    },
];

interface Category {
    id: number;
    name: string;
    slug: string;
    short_description: string;
    description: string;
    images: { image_path: string; alt_text: string }[];
}

const categories = computed<Category[]>(() => (Array.isArray((usePage().props as any).categories) ? (usePage().props as any).categories : []));

const columns = [
    { key: 'name', label: 'Kategori Adı' },
    { key: 'slug', label: 'Slug' },
    { key: 'short_description', label: 'Kısa Açıklama' },
    {
        key: 'image',
        label: 'Görsel',
        render: (_: any, row: any) => {
            if (row.images && row.images.length > 0) {
                return `<img src="/storage/${row.images[0].image_path}" alt="${row.images[0].alt_text}" class="w-12 h-12 object-cover rounded" />`;
            }
            return '-';
        },
    },
    {
        key: 'description',
        label: 'Açıklama',
        render: (_: any, row: any) => {
            const maxLen = 150;
            if (!row.description) return '-';
            return row.description.length > maxLen ? row.description.slice(0, maxLen) + '...' : row.description;
        },
    },
    { key: 'actions', label: 'İşlemler' },
];

const showDeleteModal = ref(false);
const categoryToDelete = ref<any>(null);
const message = ref('');
const messageType = ref<'success' | 'error' | ''>('');

function openDeleteModal(category: any) {
    categoryToDelete.value = category;
    showDeleteModal.value = true;
}

function closeDeleteModal() {
    showDeleteModal.value = false;
    categoryToDelete.value = null;
}

function confirmDelete() {
    if (categoryToDelete.value) {
        router.delete(`/dashboard/categories/${categoryToDelete.value.id}`, {
            onSuccess: () => {
                message.value = 'Kategori başarıyla silindi!';
                messageType.value = 'success';
                closeDeleteModal();
            },
            onError: () => {
                message.value = 'Kategori silinirken bir hata oluştu.';
                messageType.value = 'error';
                closeDeleteModal();
            },
        });
    }
}
</script>

<template>
    <Head title="Renk Oluştur" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <PageContainer>
            <div class="max-w-8xl mx-auto mt-16 overflow-x-hidden rounded-xl bg-white p-8 dark:bg-gray-900">
                <div class="mb-6 flex justify-end">
                    <Link
                        href="/dashboard/categories/create"
                        class="group light:from-gray-600 light:to-green-500 light:hover:from-gray-700 light:hover:to-green-400 light:focus:ring-offset-white inline-flex transform items-center gap-2 rounded-lg bg-gradient-to-r from-gray-800 to-green-700 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:from-gray-900 hover:to-green-600 hover:shadow-xl focus:ring-2 focus:ring-green-400 focus:ring-offset-2 focus:ring-offset-gray-900 focus:outline-none dark:from-gray-800 dark:to-green-700 dark:hover:from-gray-900 dark:hover:to-green-600 dark:focus:ring-offset-gray-900"
                    >
                        <Plus class="h-4 w-4 transition-transform duration-200 group-hover:rotate-90" />
                        Kategori Oluştur
                    </Link>
                </div>
                <div class="w-full min-w-7xl">
                    <AlertMessage :message="message" :type="messageType" />
                    <DataTable :data="categories" :columns="columns" :searchable="true" empty-message="Kayıtlı kategori yok" class="rounded">
                        <template #cell-image="{ row }">
                            <img
                                v-if="row.images && row.images.length > 0"
                                :src="`/storage/${row.images[0].image_path}`"
                                :alt="row.images[0].alt_text"
                                class="h-12 w-12 rounded object-cover"
                            />
                            <span v-else>-</span>
                        </template>
                        <template #cell-actions="{ row }">
                            <button @click="openDeleteModal(row)" class="text-red-600 hover:underline">Sil</button>
                        </template>
                    </DataTable>
                </div>
            </div>
            <!-- Delete Confirmation Modal -->
            <div
                v-if="showDeleteModal"
                class="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50"
                @click.self="closeDeleteModal"
            >
                <div class="mx-4 w-full max-w-md rounded-lg bg-white shadow-xl dark:bg-gray-800">
                    <div class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kategoriyi Sil</h3>
                        <button @click="closeDeleteModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="flex items-center space-x-2">
                            <div class="">
                                <img
                                    :src="`/storage/${categoryToDelete.images[0].image_path}`"
                                    :alt="categoryToDelete.images[0].alt_text"
                                    class="h-12 w-12 rounded object-cover"
                                />
                            </div>
                            <div class="mb-4 py-2">
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ categoryToDelete?.name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ categoryToDelete?.slug }}
                                </p>
                            </div>
                        </div>

                        <p class="mb-6 text-gray-600 dark:text-gray-300">Bu kategoriyi silmek istediğinize emin misiniz? Bu işlem geri alınamaz.</p>

                        <div class="flex justify-end space-x-3">
                            <button
                                @click="closeDeleteModal"
                                class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                            >
                                İptal
                            </button>
                            <button
                                @click="confirmDelete"
                                class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
                            >
                                Sil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </PageContainer>
    </AppLayout>
</template>
