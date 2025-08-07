<script setup lang="ts">
import { ref } from 'vue'
import { Plus, Trash2, Image as ImageIcon } from 'lucide-vue-next'
import { SectionBox, SectionHeader } from '@/components/ui/section'
import ImageUpload from '@/components/ui/image-upload.vue'

interface ProductImage {
  main_image: File | null
  main_image_alt: string
  hover_image: File | null
  hover_image_alt: string
}

interface Props {
  modelValue: ProductImage[]
  errors?: Record<string, string>
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
</script>

<template>
  <SectionBox>
    <SectionHeader
      :icon="ImageIcon"
      title="Ürün Resimleri"
      description="Ürün detay sayfasında görünecek resimler"
    />

    <!-- Add Image Button -->
    <div class="mb-6 flex items-center justify-end">
      <button
        type="button"
        @click="addImage"
        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all duration-200 hover:from-blue-700 hover:to-blue-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500/20"
      >
        <Plus class="h-4 w-4" />
        Resim Ekle
      </button>
    </div>

    <!-- Images Grid -->
    <div class="space-y-8">
      <div
        v-for="(image, index) in modelValue"
        :key="`image-${index}`"
        class="relative rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow duration-200 hover:shadow-md dark:border-gray-700 dark:bg-gray-800"
      >
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
              <ImageIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Resim Seti {{ index + 1 }}
              </h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Ana resim ve hover resmi
              </p>
            </div>
          </div>

          <!-- Remove Button -->
          <button
            v-if="modelValue.length > 1"
            type="button"
            @click="removeImage(index)"
            class="flex h-9 w-9 items-center justify-center rounded-lg text-red-500 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20"
            title="Resim setini kaldır"
          >
            <Trash2 class="h-4 w-4" />
          </button>
        </div>

        <!-- Images Grid -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
          <!-- Ana Resim -->
          <div class="space-y-4">
            <div class="flex items-center gap-2">
              <div class="h-2 w-2 rounded-full bg-green-500"></div>
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">Ana Resim</h4>
              <span class="text-xs text-red-500">*</span>
            </div>

            <ImageUpload
              :model-value="image.main_image"
              :alt-text="image.main_image_alt"
              :error="getNestedError(index, 'main_image')"
              :alt-error="getNestedError(index, 'main_image_alt')"
              description="Ürün kartında ve detay sayfasında gösterilecek ana resim"
              placeholder="Ana resim seçin"
              variant="default"
              aspect-ratio="square"
              required
              show-alt-text
              @update:model-value="updateImage(index, 'main_image', $event)"
              @update:alt-text="updateImage(index, 'main_image_alt', $event)"
            />
          </div>

          <!-- Hover Resmi -->
          <div class="space-y-4">
            <div class="flex items-center gap-2">
              <div class="h-2 w-2 rounded-full bg-blue-500"></div>
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">Hover Resmi</h4>
              <span class="text-xs text-gray-500">(Opsiyonel)</span>
            </div>

            <ImageUpload
              :model-value="image.hover_image"
              :alt-text="image.hover_image_alt"
              :error="getNestedError(index, 'hover_image')"
              :alt-error="getNestedError(index, 'hover_image_alt')"
              description="Mouse ile üzerine gelindiğinde gösterilecek resim"
              placeholder="Hover resmi seçin"
              variant="default"
              aspect-ratio="square"
              show-alt-text
              @update:model-value="updateImage(index, 'hover_image', $event)"
              @update:alt-text="updateImage(index, 'hover_image_alt', $event)"
            />
          </div>
        </div>
      </div>
    </div>
  </SectionBox>
</template>