<script setup lang="ts">
import { Plus, Trash2, Image as ImageIcon } from 'lucide-vue-next'
import { ImageUrlUpload } from '@/components/ui/input';
import axios from 'axios';

interface ProductImage {
  main_image: string | null
  main_image_alt: string
  hover_image: string | null
  hover_image_alt: string
}

interface Props {
  modelValue: ProductImage[]
  errors?: any
}

const props = defineProps<Props>()
const emit = defineEmits<{
  'update:modelValue': [value: ProductImage[]]
}>()

const addImage = () => {
  const newImages = [...props.modelValue]
  newImages.push({
    main_image: null,
    main_image_alt: '',
    hover_image: null,
    hover_image_alt: '',
  })
  emit('update:modelValue', newImages)
}

const removeImage = (index: number) => {
  if (props.modelValue.length > 1) {
    const newImages = [...props.modelValue]
    newImages.splice(index, 1)
    emit('update:modelValue', newImages)
  }
}

const updateImage = (index: number, field: keyof ProductImage, value: any) => {
  const newImages = [...props.modelValue]
  newImages[index] = {
    ...newImages[index],
    [field]: value
  }
  emit('update:modelValue', newImages)
}

const getNestedError = (index: number, field: string): string | undefined => {
  const errorKey = `images.${index}.${field}`
  return props.errors?.[errorKey]
}

const handleImageRemove = (index: number, field: 'main_image' | 'hover_image') => {
  updateImage(index, field, null)
  const altField = field === 'main_image' ? 'main_image_alt' : 'hover_image_alt'
  updateImage(index, altField, '')
}

const handleImageUpload = async (index: number, field: 'main_image' | 'hover_image', file: File) => {
  try {
    const formData = new FormData()
    formData.append('file', file)
    const response = await axios.post('/dashboard/pages/upload-image', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        'Accept': 'application/json',
      }
    })
    if (response.data.success) {
      updateImage(index, field, response.data.file_path)
      console.log('Dosya başarıyla yüklendi, path:', response.data.file_path)
    } else {
      console.error('Dosya yükleme hatası:', response.data.message)
      alert('Dosya yükleme hatası: ' + (response.data.message || 'Bilinmeyen hata'))
    }
  } catch (error) {
    console.error('Dosya yükleme hatası:', error)
    if (axios.isAxiosError(error)) {
      if (error.response?.status === 419) {
        alert('CSRF token hatası. Sayfayı yenileyin ve tekrar deneyin.')
      } else if (error.response?.status === 422) {
        alert('Dosya doğrulama hatası: ' + (error.response.data.message || 'Geçersiz dosya'))
      } else {
        alert('Dosya yükleme hatası: ' + (error.response?.data?.message || error.message))
      }
    } else {
      alert('Dosya yükleme hatası: ' + (error instanceof Error ? error.message : 'Bilinmeyen hata'))
    }
  }
}

const getImageUrl = (path: string | null): string | null => {
  if (!path) return null
  if (path.startsWith('http')) return path
  return `/storage/${path}`
}
</script>

<template>
  <div class="space-y-4">
    <div class="flex items-start justify-between gap-3">
      <div class="flex items-start gap-3 flex-1 min-w-0">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30 flex-shrink-0">
          <ImageIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
        </div>
        <div class="flex-1 min-w-0">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ürün Resimleri</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Ürün detay sayfasında görünecek resimler
          </p>
        </div>
      </div>

      <button
        type="button"
        @click="addImage"
        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 active:scale-95 flex-shrink-0"
      >
        <Plus class="h-4 w-4" />
        <span class="hidden sm:inline">Resim Ekle</span>
        <span class="sm:hidden">Ekle</span>
      </button>
    </div>

    <div class="space-y-4">
      <div
        v-for="(image, index) in modelValue"
        :key="`image-${index}`"
        class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800"
      >
        <div class="mb-4 flex items-center justify-between">
          <div class="flex items-center gap-2">
            <div class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
              {{ index + 1 }}
            </div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Resim Seti</span>
          </div>

          <button
            v-if="modelValue.length > 1"
            type="button"
            @click="removeImage(index)"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-red-500 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 active:scale-95"
          >
            <Trash2 class="h-4 w-4" />
          </button>
        </div>

        <div class="space-y-4">
          <div>
            <ImageUrlUpload
              :model-value="getImageUrl(image.main_image)"
              :alt-text="image.main_image_alt"
              :error="getNestedError(index, 'main_image')"
              :alt-error="getNestedError(index, 'main_image_alt')"
              label="Ana Resim"
              description="Ürün kartında gösterilecek ana resim"
              placeholder="Ana resim seçin"
              required
              show-alt-text
              @update:model-value="(file) => handleImageUpload(index, 'main_image', file)"
              @update:alt-text="updateImage(index, 'main_image_alt', $event)"
              @remove="handleImageRemove(index, 'main_image')"
            />
          </div>

          <div>
            <ImageUrlUpload
              :model-value="getImageUrl(image.hover_image)"
              :alt-text="image.hover_image_alt"
              :error="getNestedError(index, 'hover_image')"
              :alt-error="getNestedError(index, 'hover_image_alt')"
              label="Hover Resmi"
              description="Üzerine gelindiğinde gösterilecek resim"
              placeholder="Hover resmi seçin"
              show-alt-text
              @update:model-value="(file) => handleImageUpload(index, 'hover_image', file)"
              @update:alt-text="updateImage(index, 'hover_image_alt', $event)"
              @remove="handleImageRemove(index, 'hover_image')"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
