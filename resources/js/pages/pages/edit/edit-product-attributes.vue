<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <PageContainer>
            <div class="max-w-5xl mx-auto p-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h1 class="text-2xl font-bold text-white flex items-center">
                            <Info class="h-6 w-6 mr-3" />
                            Ürün Özelliklerini Düzenle
                        </h1>
                        <p class="text-emerald-100 mt-1">{{ product.name }} - Ürün özelliklerini yönetin</p>
                    </div>
                    <div class="p-6">
                        <!-- İstatistik Kartı -->
                        <div class="mb-8 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-lg p-4 border border-emerald-200 dark:border-emerald-800">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="p-2 bg-emerald-100 dark:bg-emerald-800 rounded-lg">
                                        <Settings class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">Toplam Özellik</p>
                                        <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ form.attributes.length }}</p>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    @click="addAttribute"
                                    class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors shadow-sm"
                                >
                                    <Plus class="h-4 w-4 mr-2" />
                                    Özellik Ekle
                                </button>
                            </div>
                        </div>
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Özellikler Listesi -->
                            <div class="space-y-4">
                                <div
                                    v-for="(attribute, idx) in form.attributes"
                                    :key="idx"
                                    class="group relative bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600 hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-200"
                                >
                                    <!-- Özellik Numarası -->
                                    <div class="absolute -top-3 left-4 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        {{ idx + 1 }}
                                    </div>
                                    <!-- Silme Butonu -->
                                    <button
                                        v-if="form.attributes.length > 1"
                                        type="button"
                                        @click="openDeleteModal(attribute, idx)"
                                        class="absolute -top-2 -right-2 p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors shadow-lg opacity-0 group-hover:opacity-100"
                                        title="Özelliği sil"
                                    >
                                        <X class="h-4 w-4" />
                                    </button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Özellik Adı -->
                                        <div class="space-y-2">
                                            <label :for="`attribute_name_${idx}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <Tag class="h-4 w-4 inline mr-1 text-emerald-500" />
                                                Özellik Adı *
                                            </label>
                                            <input
                                                :id="`attribute_name_${idx}`"
                                                v-model="attribute.name"
                                                type="text"
                                                required
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:text-white transition-colors"
                                                placeholder="örn: Malzeme, Boyut, Renk"
                                            />
                                            <p v-if="getNestedError('attributes', idx, 'name')" class="text-sm text-red-600">
                                                {{ getNestedError('attributes', idx, 'name') }}
                                            </p>
                                        </div>
                                        <!-- Özellik Değeri -->
                                        <div class="space-y-2">
                                            <label :for="`attribute_value_${idx}`" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <FileText class="h-4 w-4 inline mr-1 text-teal-500" />
                                                Özellik Değeri *
                                            </label>
                                            <input
                                                :id="`attribute_value_${idx}`"
                                                v-model="attribute.value"
                                                type="text"
                                                required
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:text-white transition-colors"
                                                placeholder="örn: Pamuk, 42, Mavi"
                                            />
                                            <p v-if="getNestedError('attributes', idx, 'value')" class="text-sm text-red-600">
                                                {{ getNestedError('attributes', idx, 'value') }}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Özellik Önizlemesi -->
                                    <div v-if="attribute.name && attribute.value" class="mt-4 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Önizleme:</p>
                                        <div class="flex items-center text-sm">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ attribute.name }}:</span>
                                            <span class="ml-2 text-gray-600 dark:text-gray-300">{{ attribute.value }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Boş Durum -->
                            <div v-if="form.attributes.length === 0" class="text-center py-12">
                                <Settings class="h-16 w-16 text-gray-400 mx-auto mb-4" />
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Henüz özellik eklenmemiş</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">Ürününüz için özellikler ekleyerek müşterilerinize daha detaylı bilgi verin</p>
                                <button
                                    type="button"
                                    @click="addAttribute"
                                    class="inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors"
                                >
                                    <Plus class="h-5 w-5 mr-2" />
                                    İlk Özelliği Ekle
                                </button>
                            </div>
                            <!-- Form Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-600">
                                <button
                                    type="button"
                                    @click="$inertia.visit(`/dashboard/pages/${product.id}`)"
                                    class="inline-flex items-center px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                >
                                    <ArrowLeft class="h-4 w-4 mr-2" />
                                    İptal
                                </button>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                >
                                    <span v-if="form.processing" class="mr-2">
                                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                                    </span>
                                    <Save v-else class="h-4 w-4 mr-2" />
                                    {{ form.processing ? 'Güncelleniyor...' : 'Değişiklikleri Kaydet' }}
                                </button>
                            </div>
                        </form>
                        <!-- Success/Error Messages -->
                        <div v-if="message" class="mt-6">
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
                        <!-- Yardım Metni -->
                        <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-start">
                                <HelpCircle class="h-5 w-5 text-blue-500 mt-0.5 mr-2 flex-shrink-0" />
                                <div class="text-sm text-blue-800 dark:text-blue-200">
                                    <p class="font-medium mb-1">💡 İpuçları:</p>
                                    <ul class="list-disc list-inside space-y-1 text-blue-700 dark:text-blue-300">
                                        <li>Özellik adları kısa ve açıklayıcı olmalı (örn: "Malzeme", "Boyut")</li>
                                        <li>Değerler spesifik ve net olmalı (örn: "100% Pamuk", "42 numara")</li>
                                        <li>Müşteriler için önemli olan özellikleri öncelikle ekleyin</li>
                                        <li>Benzer ürünlerde tutarlı özellik adları kullanın</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </PageContainer>

        <!-- Delete Confirmation Modal -->
        <div
            v-if="showDeleteModal"
            class="fixed inset-0 bg-gray-900/70 bg-opacity-50 flex items-center justify-center z-50"
            @click="closeDeleteModal"
        >
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all"
                @click.stop
            >
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded-lg mr-3">
                            <AlertCircle class="h-6 w-6 text-red-600 dark:text-red-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Özelliği Sil
                        </h3>
                    </div>
                    <button
                        @click="closeDeleteModal"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    >
                        <X class="h-5 w-5" />
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Bu özelliği silmek istediğinizden emin misiniz?
                    </p>

                    <div v-if="attributeToDelete" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <div class="flex items-center text-sm">
                            <span class="font-medium text-gray-900 dark:text-white">{{ attributeToDelete.name }}:</span>
                            <span class="ml-2 text-gray-600 dark:text-gray-300">{{ attributeToDelete.value }}</span>
                        </div>
                    </div>

                    <p class="text-sm text-red-600 dark:text-red-400">
                        Bu işlem geri alınamaz.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 dark:border-gray-600">
                    <button
                        @click="closeDeleteModal"
                        class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
                    >
                        İptal
                    </button>
                    <button
                        @click="confirmDelete"
                        :disabled="isDeleting"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center"
                    >
                        <span v-if="isDeleting" class="mr-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                        </span>
                        {{ isDeleting ? 'Siliniyor...' : 'Evet, Sil' }}
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import axios from 'axios'
import { FormActions } from '@/components/ui/form'
import { FormField } from '@/components/ui/input'
import { PageContainer } from '@/components/ui/layout'
import { SectionBox, SectionHeader } from '@/components/ui/section'
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import {
    Info,
    Settings,
    Plus,
    X,
    Tag,
    FileText,
    ArrowLeft,
    Save,
    CheckCircle,
    AlertCircle,
    HelpCircle
} from 'lucide-vue-next'

// Breadcrumbs
const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Ürünler', href: '/dashboard/pages' },
    { title: 'Özellikleri Düzenle', href: '#' },
]

// Props from controller
const page = usePage()
const product = page.props.product
const initialAttributes = Array.isArray(product.attributes) && product.attributes.length
    ? product.attributes.map(attr => ({
        id: attr.id || null, // Mevcut attribute'lar için id'yi koru
        name: attr.name || '',
        value: attr.value || ''
    }))
    : [{ id: null, name: '', value: '' }] // Yeni attribute'lar için id null

// Form
const form = useForm({
    attributes: JSON.parse(JSON.stringify(initialAttributes)),
})

// Mesajlar
const message = ref('')
const messageType = ref<'success' | 'error' | ''>('')

// Modal state
const showDeleteModal = ref(false)
const attributeToDelete = ref(null)
const attributeIndexToDelete = ref(-1)
const isDeleting = ref(false)

// Nested error getter
const getNestedError = (field: string, index: number, subField: string): string | undefined => {
    const errorKey = `${field}.${index}.${subField}`
    return (form.errors as any)[errorKey]
}

// Özellik ekle/çıkar
const addAttribute = () => {
    form.attributes.push({ id: null, name: '', value: '' }) // Yeni attribute'lar için id null
}

const removeAttribute = (idx: number) => {
    if (form.attributes.length > 1) form.attributes.splice(idx, 1)
}

// Modal functions
const openDeleteModal = (attribute: any, idx: number) => {
    attributeToDelete.value = attribute
    attributeIndexToDelete.value = idx
    showDeleteModal.value = true
}

const closeDeleteModal = () => {
    showDeleteModal.value = false
    attributeToDelete.value = null
    attributeIndexToDelete.value = -1
    isDeleting.value = false
}

const confirmDelete = async () => {
    if (!attributeToDelete.value || attributeIndexToDelete.value === -1) return

    isDeleting.value = true
    await removeAttributeFromServer(attributeToDelete.value.id, attributeIndexToDelete.value)
    closeDeleteModal()
}

// Attribute silme (axios ile)
const removeAttributeFromServer = async (attributeId: number|null, idx: number) => {
    if (!attributeId) {
        // Sadece local'den sil (henüz kaydedilmemiş)
        removeAttribute(idx)
        return
    }

    try {
        await axios.post(
            `/dashboard/pages/${product.id}/edit/attributes/remove`,
            { attribute_id: attributeId }
        )
        message.value = 'Özellik başarıyla silindi!'
        messageType.value = 'success'
        removeAttribute(idx)
    } catch (e) {
        message.value = 'Özellik silinirken bir hata oluştu.'
        messageType.value = 'error'
    }
}

// Form gönderme
const submit = () => {
    form.post(`/dashboard/pages/${productId}/edit/card/update`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            message.value = 'Özellikler başarıyla güncellendi!'
            messageType.value = 'success'
        },
        onError: () => {
            message.value = 'Bir hata oluştu. Lütfen formu kontrol edin.'
            messageType.value = 'error'
            console.error('Form error:', form.errors)
        },
    })
}
</script>
