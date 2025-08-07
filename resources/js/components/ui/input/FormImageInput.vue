<script setup lang="ts">
import { ref, watch, computed } from 'vue'

const props = defineProps<{
  modelValue?: File | null
  label?: string
  description?: string
  error?: string
  required?: boolean
  placeholder?: string
  maxSize?: number // MB
  accept?: string
  showFileInfo?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: File | null): void
  (e: 'error', error: string): void
}>()

const fileInputRef = ref<HTMLInputElement>()
const isDragging = ref(false)
const isUploading = ref(false)
const error = ref('')
const previewUrl = ref<string | null>(null)

const maxSizeBytes = computed(() => (props.maxSize || 5) * 1024 * 1024)

const validateFile = (file: File): string | null => {
  if (file.size > maxSizeBytes.value) {
    return `Dosya boyutu ${props.maxSize || 5}MB'dan büyük olamaz`
  }

  const acceptedTypes = props.accept || 'image/*'
  if (!file.type.match(acceptedTypes.replace('*', '.*'))) {
    return 'Geçersiz dosya türü'
  }

  return null
}

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return '0 Bytes'
  const k = 1024
  const sizes = ['Bytes', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(k))
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
}

const onFileChange = async (e: Event) => {
  const target = e.target as HTMLInputElement
  const file = target.files?.[0] || null

  if (file) {
    const validationError = validateFile(file)
    if (validationError) {
      error.value = validationError
      emit('error', validationError)
      return
    }

    isUploading.value = true
    error.value = ''

    // Simulate upload delay for better UX
    await new Promise(resolve => setTimeout(resolve, 800))

    previewUrl.value = URL.createObjectURL(file)
    isUploading.value = false
  } else {
    previewUrl.value = null
  }

  emit('update:modelValue', file)
}

const handleDragOver = (event: DragEvent) => {
  event.preventDefault()
  isDragging.value = true
}

const handleDragLeave = (event: DragEvent) => {
  event.preventDefault()
  isDragging.value = false
}

const handleDrop = async (event: DragEvent) => {
  event.preventDefault()
  isDragging.value = false

  const files = event.dataTransfer?.files
  if (files && files.length > 0) {
    const file = files[0]

    const validationError = validateFile(file)
    if (validationError) {
      error.value = validationError
      emit('error', validationError)
      return
    }

    isUploading.value = true
    error.value = ''

    await new Promise(resolve => setTimeout(resolve, 800))

    emit('update:modelValue', file)
    previewUrl.value = URL.createObjectURL(file)
    isUploading.value = false
  }
}

const removeFile = () => {
  emit('update:modelValue', null)
  previewUrl.value = null
  error.value = ''
  if (fileInputRef.value) fileInputRef.value.value = ''
}

const triggerFileInput = () => {
  fileInputRef.value?.click()
}

watch(() => props.modelValue, (val) => {
  if (!val) {
    previewUrl.value = null
    error.value = ''
  }
})


watch(previewUrl, (newUrl, oldUrl) => {
  if (oldUrl && oldUrl.startsWith('blob:')) {
    URL.revokeObjectURL(oldUrl)
  }
})
</script>

<template>
  <div class="space-y-3">
    <!-- Label -->
    <div v-if="label" class="flex items-center gap-2">
      <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">
        {{ label }}
      </label>
      <span v-if="required" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
        Zorunlu
      </span>
    </div>

    <!-- Description -->
    <p v-if="description" class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1">
      <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      {{ description }}
    </p>

    <!-- Upload Area -->
    <div
      class="relative border-2 border-dashed rounded-xl transition-all duration-300 overflow-hidden"
      :class="{
        'border-blue-400 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 dark:border-blue-500 shadow-lg scale-[1.02]': isDragging,
        'border-gray-300 dark:border-gray-600 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900': !isDragging && !error && !props.error,
        'border-red-400 bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-950/30 dark:to-pink-950/30 dark:border-red-500': error || props.error,
        'hover:border-gray-400 dark:hover:border-gray-500 hover:shadow-md hover:scale-[1.01]': !isDragging && !error && !props.error,
      }"
      @dragover="handleDragOver"
      @dragleave="handleDragLeave"
      @drop="handleDrop"
      @click="triggerFileInput"
    >
      <!-- Loading Overlay -->
      <div
        v-if="isUploading"
        class="absolute inset-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm flex items-center justify-center z-10"
      >
        <div class="flex flex-col items-center space-y-3">
          <div class="relative">
            <div class="w-12 h-12 border-4 border-blue-200 dark:border-blue-800 rounded-full animate-spin border-t-blue-600 dark:border-t-blue-400"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
            </div>
          </div>
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Yükleniyor...</p>
        </div>
      </div>

      <!-- Main Content -->
      <div class="p-8 text-center cursor-pointer select-none">
        <!-- Icon -->
        <div class="mb-6 relative">
          <div
            class="w-16 h-16 mx-auto rounded-2xl flex items-center justify-center transition-all duration-300"
            :class="{
              'bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/25': isDragging,
              'bg-gradient-to-br from-red-500 to-pink-600 shadow-lg shadow-red-500/25': error || props.error,
              'bg-gradient-to-br from-gray-400 to-gray-600 shadow-lg shadow-gray-500/25': !isDragging && !error && !props.error
            }"
          >
            <svg
              class="w-8 h-8 text-white transition-transform duration-300"
              :class="{ 'scale-110': isDragging }"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
              />
            </svg>
          </div>

          <!-- Floating particles effect -->
          <div v-if="isDragging" class="absolute inset-0 pointer-events-none">
            <div class="absolute top-2 left-4 w-2 h-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
            <div class="absolute top-6 right-3 w-1.5 h-1.5 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            <div class="absolute bottom-4 left-6 w-1 h-1 bg-blue-300 rounded-full animate-bounce" style="animation-delay: 0.4s;"></div>
            <div class="absolute bottom-2 right-8 w-1.5 h-1.5 bg-indigo-300 rounded-full animate-bounce" style="animation-delay: 0.6s;"></div>
          </div>
        </div>

        <!-- Text Content -->
        <div class="space-y-3">
          <h3
            class="text-xl font-bold transition-colors duration-300"
            :class="{
              'text-blue-700 dark:text-blue-300': isDragging,
              'text-red-700 dark:text-red-300': error || props.error,
              'text-gray-800 dark:text-gray-200': !isDragging && !error && !props.error
            }"
          >
            {{ isDragging ? 'Resmi buraya bırakın' : (placeholder || 'Resim yükleyin') }}
          </h3>

          <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Maksimum {{ props.maxSize || 5 }}MB • JPG, PNG, GIF, WebP
          </p>

          <!-- Action Button -->
          <div class="pt-2">
            <button
              type="button"
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
              @click.stop="triggerFileInput"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Dosya Seç
            </button>
          </div>
        </div>

        <!-- Hidden Input -->
        <input
          ref="fileInputRef"
          type="file"
          :accept="accept || 'image/*'"
          :required="required"
          class="hidden"
          @change="onFileChange"
        />
      </div>
    </div>

    <!-- Preview Section -->
    <div v-if="previewUrl && props.modelValue" class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
      <div class="flex items-start space-x-4">
        <!-- Preview Image -->
        <div class="relative group">
          <img
            :src="previewUrl"
            alt="Seçilen görsel"
            class="w-20 h-20 object-cover rounded-lg border-2 border-white dark:border-gray-700 shadow-lg group-hover:shadow-xl transition-shadow duration-200"
          />
          <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-lg transition-colors duration-200"></div>
        </div>

        <!-- File Info -->
        <div class="flex-1 min-w-0">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                {{ props.modelValue.name.length > 30 ? props.modelValue.name.slice(0, 30) + '...' : props.modelValue.name }}
              </p>
              <div class="flex items-center space-x-3 mt-1">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                  <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  Yüklendi
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400">
                  {{ formatFileSize(props.modelValue.size) }}
                </span>
              </div>
            </div>

            <!-- Remove Button -->
            <button
              type="button"
              class="flex-shrink-0 p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-lg transition-colors duration-200 group"
              @click.stop="removeFile"
            >
              <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Error Message -->
    <div v-if="error || props.error" class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-950/20 dark:to-pink-950/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
      <div class="flex items-center space-x-3">
        <div class="flex-shrink-0">
          <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
        <div>
          <p class="text-sm font-medium text-red-800 dark:text-red-200">Hata</p>
          <p class="text-sm text-red-700 dark:text-red-300">{{ error || props.error }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(-25%);
    animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
  }
  50% {
    transform: none;
    animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

.animate-bounce {
  animation: bounce 1s infinite;
}

/* Backdrop blur support */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}

/* Smooth transitions */
* {
  transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 200ms;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

.dark ::-webkit-scrollbar-track {
  background: #374151;
}

.dark ::-webkit-scrollbar-thumb {
  background: #4b5563;
}

.dark ::-webkit-scrollbar-thumb:hover {
  background: #6b7280;
}
</style>