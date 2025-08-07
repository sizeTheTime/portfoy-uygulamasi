<script setup lang="ts">
import { ref, computed } from 'vue'
import { Plus, Trash2, Image as ImageIcon, Upload, X, Edit, AlertCircle, CheckCircle, Settings } from 'lucide-vue-next'
import axios from 'axios'

interface ProductImage {
  id?: number | null
  main_image: string | null
  main_image_alt: string
  hover_image: string | null
  hover_image_alt: string
}

interface Props {
  productId: number
  initialImages?: ProductImage[]
  errors?: any
}

const props = defineProps<Props>()
const emit = defineEmits<{
  'images-updated': [images: ProductImage[]]
}>()

// State
const images = ref<ProductImage[]>(props.initialImages || [])
const loadingStates = ref<Record<string, boolean>>({})
const message = ref('')
const messageType = ref<'success' | 'error' | ''>('')

// Modal state
const showAddModal = ref(false)
const addModalData = ref({
  main_image: null as File | null,
  main_image_alt: '',
  hover_image: null as File | null,
  hover_image_alt: '',
})

// Delete modal state
const showDeleteModal = ref(false)
const deleteImageIndex = ref(-1)
const deleteImageData = ref<ProductImage | null>(null)

// Edit modal state
const showEditModal = ref(false)
const editImageIndex = ref(-1)
const editImageData = ref<ProductImage | null>(null)
const editModalData = ref({
  main_image: null as File | null,
  main_image_alt: '',
  hover_image: null as File | null,
  hover_image_alt: '',
  remove_hover_image: false,
})

// Computed
const hasImages = computed(() => images.value.length > 0)

// Methods
const showMessage = (text: string, type: 'success' | 'error') => {
  message.value = text
  messageType.value = type
  setTimeout(() => {
    message.value = ''
    messageType.value = ''
  }, 3000)
}

const setLoading = (key: string, value: boolean) => {
  loadingStates.value[key] = value
}

const isLoading = (key: string) => {
  return loadingStates.value[key] || false
}

// Path'i URL'ye çeviren yardımcı fonksiyon
const getImageUrl = (path: string | null): string | null => {
  if (!path) return null
  if (path.startsWith('http')) return path
  return `/storage/${path}`
}

// Add Modal açma/kapama
const openAddModal = () => {
  addModalData.value = {
    main_image: null,
    main_image_alt: '',
    hover_image: null,
    hover_image_alt: '',
  }
  showAddModal.value = true
}

const closeAddModal = () => {
  showAddModal.value = false
  addModalData.value = {
    main_image: null,
    main_image_alt: '',
    hover_image: null,
    hover_image_alt: '',
  }
}

// Delete Modal açma/kapama
const closeDeleteModal = () => {
  showDeleteModal.value = false
  deleteImageIndex.value = -1
  deleteImageData.value = null
}

// Edit Modal açma/kapama
const openEditModal = (index: number) => {
  const image = images.value[index]
  editImageIndex.value = index
  editImageData.value = image
  editModalData.value = {
    main_image: null,
    main_image_alt: image.main_image_alt,
    hover_image: null,
    hover_image_alt: image.hover_image_alt,
    remove_hover_image: false,
  }
  showEditModal.value = true
}

const closeEditModal = () => {
  showEditModal.value = false
  editImageIndex.value = -1
  editImageData.value = null
  editModalData.value = {
    main_image: null,
    main_image_alt: '',
    hover_image: null,
    hover_image_alt: '',
    remove_hover_image: false,
  }
}

// Modal'dan resim seti ekle
const addImageSetFromModal = async () => {
  if (!addModalData.value.main_image || !addModalData.value.main_image_alt) {
    showMessage('Ana resim ve alt text zorunludur', 'error')
    return
  }

  const loadingKey = 'add-image-set'
  setLoading(loadingKey, true)

  try {
    const formData = new FormData()
    formData.append('main_image', addModalData.value.main_image)
    formData.append('main_image_alt', addModalData.value.main_image_alt)

    if (addModalData.value.hover_image) {
      formData.append('hover_image', addModalData.value.hover_image)
    }
    if (addModalData.value.hover_image_alt) {
      formData.append('hover_image_alt', addModalData.value.hover_image_alt)
    }

    const response = await axios.post(`/dashboard/pages/${props.productId}/edit/gallery/add-set`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })

    if (response.data.success) {
      images.value.push(response.data.image)
      emit('images-updated', images.value)
      showMessage('Resim seti başarıyla eklendi', 'success')
      closeAddModal()
    }
  } catch (error) {
    console.error('Resim seti eklenirken hata:', error)
    showMessage('Resim seti eklenirken hata oluştu', 'error')
  } finally {
    setLoading(loadingKey, false)
  }
}

// Modal'dan resim seti düzenle
const editImageSetFromModal = async () => {
  if (!editImageData.value?.id) return

  const loadingKey = 'edit-image-set'
  setLoading(loadingKey, true)

  try {
    const formData = new FormData()
    formData.append('image_id', editImageData.value.id.toString())

    if (editModalData.value.main_image) {
      formData.append('main_image', editModalData.value.main_image)
    }
    formData.append('main_image_alt', editModalData.value.main_image_alt)

    if (editModalData.value.remove_hover_image) {
      formData.append('remove_hover_image', '1')
    } else {
      if (editModalData.value.hover_image) {
        formData.append('hover_image', editModalData.value.hover_image)
      }
      formData.append('hover_image_alt', editModalData.value.hover_image_alt)
    }

    const response = await axios.post(`/dashboard/pages/${props.productId}/edit/gallery/edit-set`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    })

    if (response.data.success) {
      images.value[editImageIndex.value] = response.data.image
      emit('images-updated', images.value)
      showMessage('Resim seti başarıyla güncellendi', 'success')
      closeEditModal()
    }
  } catch (error) {
    console.error('Resim seti güncellenirken hata:', error)
    showMessage('Resim seti güncellenirken hata oluştu', 'error')
  } finally {
    setLoading(loadingKey, false)
  }
}

const confirmDeleteImageSet = async () => {
  if (deleteImageIndex.value === -1 || !deleteImageData.value?.id) return

  const loadingKey = `remove-set-${deleteImageIndex.value}`
  setLoading(loadingKey, true)

  try {
    const response = await axios.delete(`/dashboard/pages/${props.productId}/edit/gallery/remove-set/${deleteImageData.value.id}`)

    if (response.data.success) {
      images.value.splice(deleteImageIndex.value, 1)
      emit('images-updated', images.value)
      showMessage('Resim seti tamamen silindi', 'success')
      closeDeleteModal()
    }
  } catch (error) {
    console.error('Resim seti silinirken hata:', error)
    showMessage('Resim seti silinirken hata oluştu', 'error')
  } finally {
    setLoading(loadingKey, false)
  }
}

// Tüm resim setini sil
const removeImageSet = async (index: number) => {
  const image = images.value[index]
  if (!image.id) return

  deleteImageIndex.value = index
  deleteImageData.value = image
  showDeleteModal.value = true
}

// Modal dosya seçme
const handleModalFileSelect = (field: 'main_image' | 'hover_image', event: Event, modalType: 'add' | 'edit' = 'add') => {
  const target = event.target as HTMLInputElement
  const file = target.files?.[0]
  if (file) {
    if (modalType === 'add') {
      addModalData.value[field] = file

      // Alt text otomatik doldur
      if (field === 'main_image' && !addModalData.value.main_image_alt) {
        const nameWithoutExt = file.name.replace(/\.[^/.]+$/, '')
        addModalData.value.main_image_alt = nameWithoutExt.replace(/[-_]+/g, ' ').trim()
      }
    } else {
      editModalData.value[field] = file

      // Hover resim kaldırma flag'ini sıfırla
      if (field === 'hover_image') {
        editModalData.value.remove_hover_image = false
      }
    }
  }
}

// Dosya önizleme
const getFilePreview = (file: File | null): string | null => {
  if (file && file instanceof File) {
    return URL.createObjectURL(file)
  }
  return null
}
</script>

<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
          <ImageIcon class="h-5 w-5 text-blue-600 dark:text-blue-400" />
        </div>
        <div>
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ürün Galerisi</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400">Resimleri gerçek zamanlı olarak yönetin</p>
        </div>
      </div>

      <!-- Add Image Set Button -->
      <button
        type="button"
        @click="openAddModal"
        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
      >
        <Plus class="h-4 w-4" />
        Resim Seti Ekle
      </button>
    </div>

    <!-- Messages -->
    <div v-if="message" class="rounded-lg px-4 py-3 flex items-center" :class="{
      'bg-green-50 text-green-800 border border-green-200 dark:bg-green-900/20 dark:text-green-200 dark:border-green-800': messageType === 'success',
      'bg-red-50 text-red-800 border border-red-200 dark:bg-red-900/20 dark:text-red-200 dark:border-red-800': messageType === 'error',
    }">
      <CheckCircle v-if="messageType === 'success'" class="h-5 w-5 mr-2 text-green-500" />
      <AlertCircle v-else class="h-5 w-5 mr-2 text-red-500" />
      {{ message }}
    </div>

    <!-- Images List -->
    <div v-if="hasImages" class="space-y-6">
      <div
        v-for="(image, index) in images"
        :key="`image-${index}-${image.id || 'new'}`"
        class="rounded-lg border border-gray-200 bg-white p-6 dark:border-gray-700 dark:bg-gray-800"
      >
        <!-- Image Set Header -->
        <div class="mb-4 flex items-center justify-between">
          <h3 class="text-sm font-medium text-gray-900 dark:text-white">
            Resim Seti {{ index + 1 }}
          </h3>
          <div class="flex items-center gap-2">
            <!-- Edit Button -->
            <button
              type="button"
              @click="openEditModal(index)"
              class="flex h-8 w-8 items-center justify-center rounded-lg text-blue-500 transition-colors hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-900/20"
              title="Resim setini düzenle"
            >
              <Settings class="h-4 w-4" />
            </button>
            <!-- Delete Button -->
            <button
              type="button"
              @click="removeImageSet(index)"
              :disabled="isLoading(`remove-set-${index}`)"
              class="flex h-8 w-8 items-center justify-center rounded-lg text-red-500 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 disabled:opacity-50"
              title="Resim setini tamamen sil"
            >
              <div v-if="isLoading(`remove-set-${index}`)" class="h-4 w-4 animate-spin rounded-full border-2 border-red-500/30 border-t-red-500"></div>
              <Trash2 v-else class="h-4 w-4" />
            </button>
          </div>
        </div>

        <!-- Images Grid -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
          <!-- Ana Resim -->
          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Ana Resim *
            </label>

            <!-- Image Display -->
            <div class="relative border-2 border-gray-300 rounded-lg overflow-hidden dark:border-gray-600">
              <!-- Image Preview -->
              <div v-if="image.main_image" class="relative">
                <img
                  :src="getImageUrl(image.main_image)"
                  :alt="image.main_image_alt"
                  class="w-full h-32 object-cover"
                />
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                  <p class="text-white text-xs truncate">{{ image.main_image_alt }}</p>
                </div>
              </div>

              <!-- Empty State -->
              <div v-else class="flex flex-col items-center justify-center h-32 bg-gray-100 dark:bg-gray-700">
                <Upload class="h-8 w-8 text-gray-400 mb-2" />
                <p class="text-sm text-gray-600 dark:text-gray-400">Ana resim yok</p>
              </div>
            </div>
          </div>

          <!-- Hover Resmi -->
          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Hover Resmi (Opsiyonel)
            </label>

            <!-- Image Display -->
            <div class="relative border-2 border-gray-300 rounded-lg overflow-hidden dark:border-gray-600">
              <!-- Image Preview -->
              <div v-if="image.hover_image" class="relative">
                <img
                  :src="getImageUrl(image.hover_image)"
                  :alt="image.hover_image_alt"
                  class="w-full h-32 object-cover"
                />
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                  <p class="text-white text-xs truncate">{{ image.hover_image_alt }}</p>
                </div>
              </div>

              <!-- Empty State -->
              <div v-else class="flex flex-col items-center justify-center h-32 bg-gray-100 dark:bg-gray-700">
                <Upload class="h-8 w-8 text-gray-400 mb-2" />
                <p class="text-sm text-gray-600 dark:text-gray-400">Hover resmi yok</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12">
      <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
        <ImageIcon class="h-12 w-12 text-gray-400" />
      </div>
      <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Henüz resim eklenmemiş</h3>
      <p class="mx-auto max-w-md text-gray-600 dark:text-gray-400 mb-4">
        Ürününüz için resim galerisi oluşturmak için ilk resim setini ekleyin.
      </p>
      <button
        type="button"
        @click="openAddModal"
        class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-3 text-sm font-medium text-white transition-colors hover:bg-blue-700"
      >
        <Plus class="h-5 w-5" />
        İlk Resim Setini Ekle
      </button>
    </div>

    <!-- Add Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50" @click="closeAddModal">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-600">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Yeni Resim Seti Ekle</h3>
          <button @click="closeAddModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <X class="h-5 w-5" />
          </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-6">
          <!-- Ana Resim -->
          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Ana Resim * <span class="text-red-500">Zorunlu</span>
            </label>

            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 dark:border-gray-600">
              <div v-if="addModalData.main_image" class="space-y-3">
                <img :src="getFilePreview(addModalData.main_image)" class="w-full h-32 object-cover rounded" />
                <button @click="addModalData.main_image = null" class="text-sm text-red-600 hover:text-red-700">
                  Resmi kaldır
                </button>
              </div>
              <div v-else class="text-center py-8">
                <Upload class="h-8 w-8 text-gray-400 mx-auto mb-2" />
                <button
                  type="button"
                  @click="$refs.modalMainImageInput.click()"
                  class="text-sm text-blue-600 hover:text-blue-700"
                >
                  Ana resim seçin
                </button>
              </div>
            </div>

            <input
              ref="modalMainImageInput"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleModalFileSelect('main_image', $event, 'add')"
            />

            <input
              v-model="addModalData.main_image_alt"
              type="text"
              placeholder="Ana resim alt text (zorunlu)"
              class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>

          <!-- Hover Resmi -->
          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Hover Resmi (Opsiyonel)
            </label>

            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 dark:border-gray-600">
              <div v-if="addModalData.hover_image" class="space-y-3">
                <img :src="getFilePreview(addModalData.hover_image)" class="w-full h-32 object-cover rounded" />
                <button @click="addModalData.hover_image = null" class="text-sm text-red-600 hover:text-red-700">
                  Resmi kaldır
                </button>
              </div>
              <div v-else class="text-center py-8">
                <Upload class="h-8 w-8 text-gray-400 mx-auto mb-2" />
                <button
                  type="button"
                  @click="$refs.modalHoverImageInput.click()"
                  class="text-sm text-blue-600 hover:text-blue-700"
                >
                  Hover resmi seçin
                </button>
              </div>
            </div>

            <input
              ref="modalHoverImageInput"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleModalFileSelect('hover_image', $event, 'add')"
            />

            <input
              v-model="addModalData.hover_image_alt"
              type="text"
              placeholder="Hover resmi alt text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 dark:border-gray-600">
          <button
            @click="closeAddModal"
            class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
          >
            İptal
          </button>
          <button
            @click="addImageSetFromModal"
            :disabled="isLoading('add-image-set') || !addModalData.main_image || !addModalData.main_image_alt"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2"
          >
            <div v-if="isLoading('add-image-set')" class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></div>
            {{ isLoading('add-image-set') ? 'Ekleniyor...' : 'Resim Seti Ekle' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div v-if="showEditModal" class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50" @click="closeEditModal">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-600">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg mr-3">
              <Settings class="h-6 w-6 text-blue-600 dark:text-blue-400" />
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
              Resim Seti Düzenle
            </h3>
          </div>
          <button @click="closeEditModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <X class="h-5 w-5" />
          </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-6">
          <!-- Ana Resim -->
          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Ana Resim
            </label>

            <!-- Mevcut Ana Resim -->
            <div v-if="editImageData?.main_image" class="mb-3">
              <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Mevcut ana resim:</p>
              <img :src="getImageUrl(editImageData.main_image)" class="w-full h-24 object-cover rounded border" />
            </div>

            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 dark:border-gray-600">
              <div v-if="editModalData.main_image" class="space-y-3">
                <p class="text-xs text-green-600 dark:text-green-400 mb-2">Yeni ana resim:</p>
                <img :src="getFilePreview(editModalData.main_image)" class="w-full h-32 object-cover rounded" />
                <button @click="editModalData.main_image = null" class="text-sm text-red-600 hover:text-red-700">
                  Yeni resmi kaldır
                </button>
              </div>
              <div v-else class="text-center py-8">
                <Upload class="h-8 w-8 text-gray-400 mx-auto mb-2" />
                <button
                  type="button"
                  @click="$refs.editModalMainImageInput.click()"
                  class="text-sm text-blue-600 hover:text-blue-700"
                >
                  Yeni ana resim seçin
                </button>
              </div>
            </div>

            <input
              ref="editModalMainImageInput"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleModalFileSelect('main_image', $event, 'edit')"
            />

            <input
              v-model="editModalData.main_image_alt"
              type="text"
              placeholder="Ana resim alt text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>

          <!-- Hover Resmi -->
          <div class="space-y-3">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
              Hover Resmi (Opsiyonel)
            </label>

            <!-- Mevcut Hover Resim -->
            <div v-if="editImageData?.hover_image && !editModalData.remove_hover_image" class="mb-3">
              <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Mevcut hover resmi:</p>
              <div class="relative">
                <img :src="getImageUrl(editImageData.hover_image)" class="w-full h-24 object-cover rounded border" />
                <button
                  @click="editModalData.remove_hover_image = true"
                  class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors"
                  title="Hover resmi kaldır"
                >
                  <X class="h-3 w-3" />
                </button>
              </div>
            </div>

            <!-- Hover Resim Kaldırıldı Mesajı -->
            <div v-if="editModalData.remove_hover_image" class="mb-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
              <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                <AlertCircle class="h-4 w-4 mr-2" />
                Hover resmi kaldırılacak
              </p>
              <button
                @click="editModalData.remove_hover_image = false"
                class="text-sm text-red-600 hover:text-red-700 underline mt-1"
              >
                Geri al
              </button>
            </div>

            <div v-if="!editModalData.remove_hover_image" class="border-2 border-dashed border-gray-300 rounded-lg p-4 dark:border-gray-600">
              <div v-if="editModalData.hover_image" class="space-y-3">
                <p class="text-xs text-green-600 dark:text-green-400 mb-2">Yeni hover resmi:</p>
                <img :src="getFilePreview(editModalData.hover_image)" class="w-full h-32 object-cover rounded" />
                <button @click="editModalData.hover_image = null" class="text-sm text-red-600 hover:text-red-700">
                  Yeni resmi kaldır
                </button>
              </div>
              <div v-else class="text-center py-8">
                <Upload class="h-8 w-8 text-gray-400 mx-auto mb-2" />
                <button
                  type="button"
                  @click="$refs.editModalHoverImageInput.click()"
                  class="text-sm text-blue-600 hover:text-blue-700"
                >
                  {{ editImageData?.hover_image ? 'Yeni hover resmi seçin' : 'Hover resmi seçin' }}
                </button>
              </div>
            </div>

            <input
              ref="editModalHoverImageInput"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleModalFileSelect('hover_image', $event, 'edit')"
            />

            <input
              v-if="!editModalData.remove_hover_image"
              v-model="editModalData.hover_image_alt"
              type="text"
              placeholder="Hover resmi alt text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
            />
          </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 dark:border-gray-600">
          <button
            @click="closeEditModal"
            class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
          >
            İptal
          </button>
          <button
            @click="editImageSetFromModal"
            :disabled="isLoading('edit-image-set')"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2"
          >
            <div v-if="isLoading('edit-image-set')" class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></div>
            {{ isLoading('edit-image-set') ? 'Güncelleniyor...' : 'Değişiklikleri Kaydet' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-900/70 flex items-center justify-center z-50" @click="closeDeleteModal">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4" @click.stop>
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-600">
          <div class="flex items-center">
            <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded-lg mr-3">
              <AlertCircle class="h-6 w-6 text-red-600 dark:text-red-400" />
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
              Resim Setini Sil
            </h3>
          </div>
          <button @click="closeDeleteModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <X class="h-5 w-5" />
          </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
          <p class="text-gray-600 dark:text-gray-300 mb-4">
            Bu resim setini tamamen silmek istediğinizden emin misiniz?
          </p>

          <div v-if="deleteImageData" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
            <div class="grid grid-cols-2 gap-4">
              <div v-if="deleteImageData.main_image">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Ana Resim:</p>
                <img :src="getImageUrl(deleteImageData.main_image)" class="w-full h-16 object-cover rounded" />
              </div>
              <div v-if="deleteImageData.hover_image">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Hover Resmi:</p>
                <img :src="getImageUrl(deleteImageData.hover_image)" class="w-full h-16 object-cover rounded" />
              </div>
            </div>
          </div>

          <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-3 border border-red-200 dark:border-red-800">
            <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
              <AlertCircle class="h-4 w-4 mr-2" />
              Bu işlem geri alınamaz. Ana resim, hover resmi ve tüm alt textler silinecektir.
            </p>
          </div>
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
            @click="confirmDeleteImageSet"
            :disabled="isLoading(`remove-set-${deleteImageIndex}`)"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center gap-2"
          >
            <div v-if="isLoading(`remove-set-${deleteImageIndex}`)" class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></div>
            {{ isLoading(`remove-set-${deleteImageIndex}`) ? 'Siliniyor...' : 'Evet, Sil' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
