<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-6xl mx-auto p-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Ürün Renkleri Düzenle</h1>
                            <p class="text-blue-100 mt-1">Ürününüz için renk seçeneklerini yönetin</p>
                        </div>
                        <!-- Geri Dönme Butonu -->
                        <Link
                            :href="`/dashboard/pages/${productId}`"
                            class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-200 backdrop-blur-sm border border-white/20"
                        >
                            <ArrowLeft class="h-4 w-4 mr-2" />
                            Geri Dön
                        </Link>
                    </div>
                </div>

                <div class="p-6">
                    <!-- İstatistikler -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg">
                                    <CheckCircle class="h-6 w-6 text-green-600 dark:text-green-400" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800 dark:text-green-200">Seçili Renkler</p>
                                    <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ usedColors.length }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                                    <PlusCircle class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Mevcut Renkler</p>
                                    <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ unusedColors.length }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-100 dark:bg-purple-800 rounded-lg">
                                    <Palette class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-purple-800 dark:text-purple-200">Toplam Renk</p>
                                    <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ totalColors }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Seçili Renkler -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <CheckCircle class="h-5 w-5 text-green-500 mr-2" />
                                    Seçili Renkler ({{ usedColors.length }})
                                </h2>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 min-h-[300px]">
                                <div v-if="usedColors.length === 0" class="flex flex-col items-center justify-center h-full text-gray-500 dark:text-gray-400">
                                    <Palette class="h-12 w-12 mb-2 opacity-50" />
                                    <p class="text-sm">Henüz renk seçilmemiş</p>
                                    <p class="text-xs">Sağdaki renklerden seçim yapın</p>
                                </div>

                                <div v-else class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <div
                                        v-for="color in usedColors"
                                        :key="`used-${color.id}`"
                                        class="group relative bg-white dark:bg-gray-600 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-500 hover:shadow-md transition-all duration-200"
                                    >
                                        <!-- Renk Örneği -->
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-400 shadow-sm"
                                                :style="{ backgroundColor: color.hex_code }"
                                            ></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ color.name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ color.hex_code }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Kaldır Butonu -->
                                        <button
                                            @click="removeColor(color.id)"
                                            :disabled="processing"
                                            class="absolute top-1 right-1 p-1 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 opacity-0 group-hover:opacity-100 transition-opacity disabled:opacity-50"
                                            :title="`${color.name} rengini kaldır`"
                                        >
                                            <X class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mevcut Renkler -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <PlusCircle class="h-5 w-5 text-blue-500 mr-2" />
                                    Mevcut Renkler ({{ unusedColors.length }})
                                </h2>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 min-h-[300px]">
                                <div v-if="unusedColors.length === 0" class="flex flex-col items-center justify-center h-full text-gray-500 dark:text-gray-400">
                                    <CheckCircle class="h-12 w-12 mb-2 opacity-50" />
                                    <p class="text-sm">Tüm renkler seçilmiş</p>
                                    <p class="text-xs">Harika! Tüm renk seçenekleri aktif</p>
                                </div>

                                <div v-else class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    <div
                                        v-for="color in unusedColors"
                                        :key="`unused-${color.id}`"
                                        class="group relative bg-white dark:bg-gray-600 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-500 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-200 cursor-pointer"
                                        @click="addColor(color.id)"
                                    >
                                        <!-- Renk Örneği -->
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-400 shadow-sm"
                                                :style="{ backgroundColor: color.hex_code }"
                                            ></div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ color.name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ color.hex_code }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Ekle İkonu -->
                                        <div class="absolute top-1 right-1 p-1 text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <Plus class="h-4 w-4" />
                                        </div>

                                        <!-- Hover Overlay -->
                                        <div class="absolute inset-0 bg-blue-500/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useForm, usePage, Link } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { CheckCircle, PlusCircle, Palette, X, Plus, ArrowLeft } from 'lucide-vue-next'

// Breadcrumbs
const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Ürünler', href: '/dashboard/products' },
    { title: 'Renk Düzenle', href: '#' }
]

// Props from controller
const page = usePage()
const productId = page.props.product_id || page.props.productId
const usedColors = ref([...page.props.usedColors])
const unusedColors = ref([...page.props.unusedColors])

// State
const processing = ref(false)

// Computed
const totalColors = computed(() => usedColors.value.length + unusedColors.value.length)

// Methods
const addColor = async (colorId: number) => {
    if (processing.value) return

    processing.value = true

    try {
        await useForm({ color_id: colorId }).post(`/dashboard/pages/${productId}/edit/colors/add`, { preserveScroll: true })

        // Local state güncelle
        const colorIndex = unusedColors.value.findIndex(c => c.id === colorId)
        if (colorIndex !== -1) {
            const color = unusedColors.value.splice(colorIndex, 1)[0]
            usedColors.value.push(color)
        }
    } catch (error) {
        console.error('Renk eklenirken hata:', error)
    } finally {
        processing.value = false
    }
}

const removeColor = async (colorId: number) => {
    if (processing.value) return

    processing.value = true

    try {
        await useForm({ color_id: colorId }).post(`/dashboard/pages/${productId}/edit/colors/remove`, { preserveScroll: true })

        // Local state güncelle
        const colorIndex = usedColors.value.findIndex(c => c.id === colorId)
        if (colorIndex !== -1) {
            const color = usedColors.value.splice(colorIndex, 1)[0]
            unusedColors.value.push(color)
        }
    } catch (error) {
        console.error('Renk kaldırılırken hata:', error)
    } finally {
        processing.value = false
    }
}
</script>
