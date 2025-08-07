<script setup lang="ts">
import { CancelButton, SubmitButton } from '@/components/ui/button';
import { ColSpan, FormGrid } from '@/components/ui/grid';
import { FormInput, FormLabel, InputError } from '@/components/ui/input';
import { PageContainer } from '@/components/ui/layout';
import { SectionBox, SectionHeader } from '@/components/ui/section';
import DataTable from '@/components/ui/table/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { Palette, Trash2, X } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const form = useForm({
    name: '',
    hex_code: '',
});

const message = ref('');
const messageType = ref<'success' | 'error' | ''>('');

// Modal state
const showDeleteModal = ref(false);
const colorToDelete = ref<any>(null);

const submit = () => {
    form.post('/dashboard/colors', {
        onSuccess: () => {
            message.value = 'Renk başarıyla eklendi!';
            messageType.value = 'success';
            form.reset();
            form.clearErrors();
        },
        onError: () => {
            message.value = 'Bir hata oluştu. Lütfen formu kontrol edin.';
            messageType.value = 'error';
        },
    });
};

// Tüm renkleri al
const colors = computed<any[]>(() => (Array.isArray((usePage().props as any).colors) ? (usePage().props as any).colors : []));

// DataTable için kolonlar
const columns = [
    { key: 'name', label: 'Adı' },
    { key: 'hex_code', label: 'HEX Kodu' },
    {
        key: 'preview',
        label: 'Önizleme',
        render: (_: any, row: any) =>
            `<span style="display:inline-block;width:24px;height:24px;background:${row.hex_code};border-radius:4px;border:1px solid #ccc;"></span>`,
    },
    { key: 'actions', label: 'İşlemler' },
];

function openDeleteModal(color: any) {
    colorToDelete.value = color;
    showDeleteModal.value = true;
}

function closeDeleteModal() {
    showDeleteModal.value = false;
    colorToDelete.value = null;
}

function confirmDelete() {
    if (colorToDelete.value) {
        router.delete(`/dashboard/colors/${colorToDelete.value.id}`, {
            onSuccess: () => {
                message.value = 'Renk başarıyla silindi!';
                messageType.value = 'success';
                closeDeleteModal();
            },
            onError: () => {
                message.value = 'Renk silinirken bir hata oluştu.';
                messageType.value = 'error';
                closeDeleteModal();
            },
        });
    }
}
</script>

<template>
    <AppLayout>
        <Head title="Renk Oluştur" />
        <PageContainer>
            <div class="mx-auto max-w-4xl">
                <div v-if="message" class="mb-6">
                    <div
                        class="rounded px-4 py-3"
                        :class="{
                            'border border-green-300 bg-green-100 text-green-800': messageType === 'success',
                            'border border-red-300 bg-red-100 text-red-800': messageType === 'error',
                        }"
                    >
                        {{ message }}
                    </div>
                </div>

                <form @submit.prevent="submit" class="rounded-2xl p-8 dark:bg-gray-800">
                    <FormGrid>
                        <ColSpan :span="'col-span-5 space-y-6'">
                            <SectionBox>
                                <SectionHeader
                                    :icon="Palette"
                                    title="Yeni Renk Ekle"
                                    description="Renk adını ve HEX kodunu girerek yeni bir renk ekleyin."
                                />
                                <div>
                                    <FormLabel for="name" label="Renk Adı *" description="Eklemek istediğiniz rengin adı" />
                                    <FormInput id="name" v-model="form.name" type="text" placeholder="örn: Kırmızı" />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div>
                                    <FormLabel for="hex_code" label="HEX Kodu *" description="Rengin HEX kodu (örn: #FF0000)" />
                                    <FormInput id="hex_code" v-model="form.hex_code" type="text" placeholder="#FF0000" />
                                    <InputError :message="form.errors.hex_code" />
                                </div>
                                <div class="flex justify-end space-x-4">
                                    <CancelButton />
                                    <SubmitButton :loading="form.processing" label="Renk Ekle" loadingLabel="Ekleniyor..." />
                                </div>
                            </SectionBox>
                        </ColSpan>
                    </FormGrid>
                </form>
            </div>

            <div class="mx-auto mt-8 max-w-4xl rounded-2xl bg-white p-8 dark:bg-gray-900">
                <DataTable :data="colors" :columns="columns" :searchable="true" empty-message="Kayıtlı renk yok" class="rounded">
                    <template #cell-preview="{ row }">
                        <span
                            :style="{
                                backgroundColor: row.hex_code,
                                display: 'inline-block',
                                width: '24px',
                                height: '24px',
                                borderRadius: '2px',
                                border: '1px solid #ccc',
                            }"
                        ></span>
                    </template>
                    <template #cell-actions="{ row }">
                        <button
                            class="flex items-center gap-1 rounded-md p-2 text-red-600 transition-colors hover:bg-red-50 hover:text-red-800"
                            @click="openDeleteModal(row)"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </template>
                </DataTable>
            </div>

            <!-- Delete Confirmation Modal -->
            <div
                v-if="showDeleteModal"
                class="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50"
                @click.self="closeDeleteModal"
            >
                <div class="mx-4 w-full max-w-md rounded-lg bg-white shadow-xl dark:bg-gray-800">
                    <div class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rengi Sil</h3>
                        <button @click="closeDeleteModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="mb-4 flex items-center space-x-3">
                            <span
                                v-if="colorToDelete"
                                :style="{
                                    backgroundColor: colorToDelete.hex_code,
                                    display: 'inline-block',
                                    width: '32px',
                                    height: '32px',
                                    borderRadius: '4px',
                                    border: '1px solid #ccc',
                                }"
                            ></span>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ colorToDelete?.name }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ colorToDelete?.hex_code }}
                                </p>
                            </div>
                        </div>

                        <p class="mb-6 text-gray-600 dark:text-gray-300">Bu rengi silmek istediğinize emin misiniz? Bu işlem geri alınamaz.</p>

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
