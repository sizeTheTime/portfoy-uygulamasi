<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { Upload, X, RotateCcw } from 'lucide-vue-next'

interface Props {
  id?: string
  modelValue: string | null  // URL string
  altText?: string
  label?: string
  description?: string
  error?: string
  altError?: string
  required?: boolean
  disabled?: boolean
  accept?: string
  maxSize?: number
  showPreview?: boolean
  showAltText?: boolean
  placeholder?: string
}

const props = withDefaults(defineProps<Props>(), {
  accept: 'image/jpeg,image/png,image/jpg,image/webp',
  maxSize: 5,
  showPreview: true,
  showAltText: true,
  placeholder: 'Resim seçin veya sürükleyip bırakın'
})

const emit = defineEmits<{
  'update:modelValue': [value: File]  // File gönderiyoruz
  'update:altText': [value: string]
}>()

// Reactive state
const isDragOver = ref(false)
const isLoading = ref(false)
const fileInputRef = ref<HTMLInputElement>()
const selectedFile = ref<File | null>(null)
const previewUrl = ref<string>()

// Computed properties
const computedId = computed(() => props.id || `image-url-upload-${Math.random().toString(36).substr(2, 9)}`)

const fileInfo = computed(() => {
  if (!selectedFile.value) return null
  const sizeInMB = (selectedFile.value.size / (1024 * 1024)).toFixed(2)
  return {
    name: selectedFile.value.name,
    size: `${sizeInMB} MB`,
    type: selectedFile.value.type
  }
})

const containerClasses = computed(() => {
  let classes = 'relative w-full min-h-[200px] rounded-lg border-2 border-dashed transition-all duration-200 cursor-pointer'

  if (props.disabled) {
    classes += ' border-gray-200 bg-gray-50 cursor-not-allowed dark:border-gray-700 dark:bg-gray-800'
  } else if (isDragOver.value) {
    classes += ' border-blue-400 bg-blue-50 dark:border-blue-500 dark:bg-blue-900/20'
  } else if (props.error) {
    classes += ' border-red-300 bg-red-50 hover:border-red-400 dark:border-red-600 dark:bg-red-900/20'
  } else {
    classes += ' border-gray-300 bg-gray-50 hover:border-gray-400 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:hover:border-gray-500 dark:hover:bg-gray-700'
  }

  return classes
})

// Methods
const createObjectURL = (file: File): string => {
  return window.URL.createObjectURL(file)
}

const revokeObjectURL = (url: string): void => {
  window.URL.revokeObjectURL(url)
}

const validateFile = (file: File): string | null => {
  // Dosya boyutu kontrolü
  const maxSizeInBytes = props.maxSize * 1024 * 1024
  if (file.size > maxSizeInBytes) {
    return `Dosya boyutu ${props.maxSize}MB'dan büyük olamaz`
  }

  // Dosya tipi kontrolü
  if (!file.type.startsWith('image/')) {
    return 'Sadece resim dosyaları kabul edilir'
  }

  return null
}

const generatePreview = (file: File) => {
  if (file && file.type.startsWith('image/')) {
    if (previewUrl.value) {
      revokeObjectURL(previewUrl.value)
    }
    previewUrl.value = createObjectURL(file)
  }
}

const handleFileSelect = (event: Event) => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]

  if (file) {
    const error = validateFile(file)
    if (error) {
      alert(error)
      target.value = ''
      return
    }

    isLoading.value = true
    selectedFile.value = file
    generatePreview(file)

    setTimeout(() => {
      emit('update:modelValue', file)  // File'ı emit ediyoruz
      isLoading.value = false
    }, 300)
  }
}

const handleDrop = (event: DragEvent) => {
  event.preventDefault()
  isDragOver.value = false

  if (props.disabled) return

  const files = event.dataTransfer?.files
  if (files && files.length > 0) {
    const file = files[0]
    const error = validateFile(file)
    if (error) {
      alert(error)
      return
    }

    isLoading.value = true
    selectedFile.value = file
    generatePreview(file)

    setTimeout(() => {
      emit('update:modelValue', file)  // File'ı emit ediyoruz
      isLoading.value = false
    }, 300)
  }
}

const handleDragOver = (event: DragEvent) => {
  event.preventDefault()
  if (!props.disabled) {
    isDragOver.value = true
  }
}

const handleDragLeave = () => {
  isDragOver.value = false
}

const removeFile = () => {
  selectedFile.value = null
  if (previewUrl.value) {
    revokeObjectURL(previewUrl.value)
    previewUrl.value = undefined
  }
  if (fileInputRef.value) {
    fileInputRef.value.value = ''
  }
}

const openFileDialog = () => {
  if (!props.disabled && fileInputRef.value) {
    fileInputRef.value.click()
  }
}

// Watch for modelValue changes (URL string)
watch(() => props.modelValue, (newValue) => {
  // Eğer parent'tan URL geliyorsa, selectedFile'ı temizle
  if (!newValue) {
    selectedFile.value = null
    if (previewUrl.value) {
      revokeObjectURL(previewUrl.value)
      previewUrl.value = undefined
    }
  }
}, { immediate: true })

// Cleanup on unmount
watch(() => selectedFile.value, (newFile, oldFile) => {
  if (oldFile && previewUrl.value) {
    revokeObjectURL(previewUrl.value)
  }
})
</script>

<template>
  <div class="space-y-3">
    <!-- Label -->
    <div v-if="label" class="space-y-1">
      <label
        :for="computedId"
        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
      >
        {{ label }}
        <span v-if="required" class="text-red-500 ml-1">*</span>
      </label>
      <p v-if="description" class="text-xs text-gray-500 dark:text-gray-400">
        {{ description }}
      </p>
    </div>

    <!-- Upload Area -->
    <div
      :class="containerClasses"
      @drop="handleDrop"
      @dragover="handleDragOver"
      @dragleave="handleDragLeave"
      @click="openFileDialog"
    >
      <!-- Hidden File Input -->
      <input
        ref="fileInputRef"
        :id="computedId"
        type="file"
        :accept="accept"
        :disabled="disabled"
        class="hidden"
        @change="handleFileSelect"
      />

      <!-- Loading State -->
      <div v-if="isLoading" class="absolute inset-0 flex items-center justify-center bg-white/80 dark:bg-gray-800/80 rounded-lg">
        <div class="flex flex-col items-center gap-2">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="text-sm text-gray-600 dark:text-gray-400">Yükleniyor...</span>
        </div>
      </div>

      <!-- File Preview - URL'den veya seçilen dosyadan -->
      <div v-else-if="modelValue || (selectedFile && previewUrl)" class="absolute inset-0 p-4">
        <div class="relative h-full w-full rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
          <img
            :src="modelValue || previewUrl"
            :alt="altText || 'Önizleme'"
            class="h-full w-full object-cover"
          />

          <!-- Overlay -->
          <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-colors duration-200 flex items-center justify-center opacity-0 hover:opacity-100">
            <div class="flex gap-2">
              <button
                type="button"
                @click.stop="openFileDialog"
                class="p-2 bg-white/90 hover:bg-white text-gray-700 rounded-full transition-colors"
                title="Değiştir"
              >
                <RotateCcw class="h-4 w-4" />
              </button>
              <button
                type="button"
                @click.stop="removeFile"
                class="p-2 bg-red-500/90 hover:bg-red-500 text-white rounded-full transition-colors"
                title="Kaldır"
              >
                <X class="h-4 w-4" />
              </button>
            </div>
          </div>

          <!-- File Info -->
          <div v-if="fileInfo" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
            <div class="text-white text-xs">
              <p class="font-medium truncate">{{ fileInfo.name }}</p>
              <p class="text-white/80">{{ fileInfo.size }}</p>
            </div>
          </div>

          <!-- URL Info -->
          <div v-else-if="modelValue" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-3">
            <div class="text-white text-xs">
              <p class="font-medium">Yüklenmiş Resim</p>
              <p class="text-white/80 truncate">{{ modelValue }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="flex flex-col items-center justify-center h-full p-6 text-center">
        <div class="mb-4">
          <Upload
            :class="[
              'h-12 w-12',
              isDragOver
                ? 'text-blue-500'
                : error
                  ? 'text-red-400'
                  : 'text-gray-400'
            ]"
          />
        </div>
        <div class="space-y-2">
          <p class="text-base font-medium text-gray-700 dark:text-gray-300">
            {{ placeholder }}
          </p>
          <p class="text-xs text-gray-500 dark:text-gray-400">
            JPG, PNG, WEBP • Max {{ maxSize }}MB
          </p>
        </div>
        <div v-if="isDragOver" class="mt-2">
          <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">
            Dosyayı bırakın
          </p>
        </div>
      </div>
    </div>

    <!-- Alt Text Input -->
    <div v-if="showAltText && (modelValue || selectedFile)" class="space-y-1">
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Alt Text
        <span v-if="required" class="text-red-500 ml-1">*</span>
      </label>
      <input
        :value="altText"
        @input="$emit('update:altText', ($event.target as HTMLInputElement).value)"
        type="text"
        placeholder="Resim açıklaması (SEO için önemli)"
        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
      />
      <p v-if="altError" class="text-sm text-red-600 dark:text-red-400">{{ altError }}</p>
    </div>

    <!-- Error Message -->
    <p v-if="error" class="text-sm text-red-600 dark:text-red-400">{{ error }}</p>

  </div>


</template>
