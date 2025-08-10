<script setup lang="ts">
import { Plus, Trash2, Image as ImageIcon } from 'lucide-vue-next'
import { ImageUrlUpload } from '@/components/ui/input';
import axios from 'axios';

interface ProductImage {
  main_image: string | null  // File yerine string
  main_image_alt: string
  hover_image: string | null  // File yerine string
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

// Methods
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

// Resim silme fonksiyonu - URL'yi null yapar
const handleImageRemove = (index: number, field: 'main_image' | 'hover_image') => {
  updateImage(index, field, null)
  // Alt text'i de temizle
  const altField = field === 'main_image' ? 'main_image_alt' : 'hover_image_alt'
  updateImage(index, altField, '')
}

// Axios ile dosya yükleme işlemi - SADECE PATH DÖNDÜRÜR
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
      // SADECE PATH'İ KAYDET, URL DEĞİL!
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

// Path'i URL'ye çeviren yardımcı fonksiyon
const getImageUrl = (path: string | null): string | null => {
  if (!path) return null

  // Eğer zaten tam URL ise olduğu gibi döndür
  if (path.startsWith('http')) return path

  // Path'i URL'ye çevir
  return `/storage/${path}`
}
</script>

<template>
  <div class="space-y-3 md:space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row  items-center justify-between">
      <div class="flex items-center gap-1 md:gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
          <ImageIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
        </div>
        <div>
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ürün Resimleri</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400">Ürün detay sayfasında görünecek resimler</p>
        </div>
      </div>
      <!-- Add Image Button -->
      <button
        type="button"
        @click="addImage"
        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
      >
        <Plus class="h-4 w-4" />
        Resim Ekle
      </button>
    </div>

    <!-- Images List -->
    <div class="space-y-6">
      <div
        v-for="(image, index) in modelValue"
        :key="`image-${index}`"
        class="rounded-lg border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800"
      >
        <!-- Image Set Header -->
        <div class="mb-4 flex items-center justify-end">
          <button
            v-if="modelValue.length > 1"
            type="button"
            @click="removeImage(index)"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-red-500 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20"
            title="Resim setini kaldır"
          >
            <Trash2 class="h-4 w-4" />
          </button>
        </div>

        <!-- Images Grid -->
        <div class="grid grid-cols-1 gap-2 md:gap-6 lg:grid-cols-2">
          <!-- Ana Resim -->
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

          <!-- Hover Resmi -->
          <div>
            <ImageUrlUpload
              :model-value="getImageUrl(image.hover_image)"
              :alt-text="image.hover_image_alt"
              :error="getNestedError(index, 'hover_image')"
              :alt-error="getNestedError(index, 'hover_image_alt')"
              label="Hover Resmi (Opsiyonel)"
              description="Mouse ile üzerine gelindiğinde gösterilecek resim"
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
