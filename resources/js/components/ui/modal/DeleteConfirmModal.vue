<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-[9999] overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <!-- Backdrop overlay - Lower z-index -->
    <div
      class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity dark:bg-black/70"
      aria-hidden="true"
      @click="closeModal"
    ></div>

    <!-- Modal container - Higher z-index -->
    <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
      <!-- Centering span for desktop -->
      <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

      <!-- Modal panel with higher z-index -->
      <div
        class="relative z-10 inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-2xl ring-1 ring-black/5 transition-all dark:bg-gray-800 dark:ring-white/10 dark:shadow-2xl sm:my-8 sm:w-full sm:max-w-lg sm:align-middle"
      >
        <!-- Header section -->
        <div class="bg-white px-4 pb-4 pt-5 dark:bg-gray-800 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <!-- Warning Icon with enhanced styling -->
            <div
              class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 shadow-lg dark:bg-red-900/30 sm:mx-0 sm:h-10 sm:w-10"
            >
              <AlertTriangle class="h-6 w-6 text-red-600 dark:text-red-400" />
            </div>

            <!-- Content with better typography -->
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3
                class="text-lg font-semibold leading-6 text-gray-900 dark:text-white"
                id="modal-title"
              >
                Blog Yazısını Sil
              </h3>
              <div class="mt-3 space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                  <strong class="font-medium text-gray-900 dark:text-white">"{{ blogTitle }}"</strong>
                  başlıklı blog yazısını silmek istediğinizden emin misiniz?
                </p>
                <div class="rounded-lg bg-red-50 p-3 dark:bg-red-900/20">
                  <p class="text-sm font-medium text-red-800 dark:text-red-300">
                    ⚠️ Bu işlem geri alınamaz
                  </p>
                  <p class="mt-1 text-xs text-red-700 dark:text-red-400">
                    Blog yazısı, görselleri ve tüm içeriği kalıcı olarak silinecektir.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions section with enhanced styling -->
        <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700/50 sm:flex sm:flex-row-reverse sm:px-6">
          <!-- Delete button -->
          <button
            type="button"
            :disabled="isDeleting"
            @click="confirmDelete"
            class="inline-flex w-full justify-center items-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-500 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:bg-red-400 disabled:cursor-not-allowed disabled:shadow-none dark:bg-red-600 dark:hover:bg-red-500 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto"
          >
            <span v-if="isDeleting" class="mr-2 h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span>
            <Trash2 v-else class="mr-2 h-4 w-4" />
            {{ isDeleting ? 'Siliniyor...' : 'Evet, Sil' }}
          </button>

          <!-- Cancel button -->
          <button
            type="button"
            :disabled="isDeleting"
            @click="closeModal"
            class="mt-3 inline-flex w-full justify-center items-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 transition-all duration-200 hover:bg-gray-50 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 disabled:bg-gray-100 disabled:cursor-not-allowed disabled:text-gray-400 dark:bg-gray-600 dark:text-white dark:ring-gray-500 dark:hover:bg-gray-500 dark:focus:ring-offset-gray-800 sm:mt-0 sm:w-auto"
          >
            <X class="mr-2 h-4 w-4" />
            İptal
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onUnmounted } from 'vue'
import { AlertTriangle, Trash2, X } from 'lucide-vue-next'

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false
  },
  blogTitle: {
    type: String,
    required: true
  },
  blogId: {
    type: [String, Number],
    required: true
  }
})

const emit = defineEmits(['close', 'confirm'])

const isDeleting = ref(false)

const closeModal = () => {
  if (!isDeleting.value) {
    emit('close')
  }
}

const confirmDelete = async () => {
  isDeleting.value = true
  try {
    await emit('confirm', props.blogId)
  } finally {
    isDeleting.value = false
  }
}

// ESC tuşu ile modal kapatma
const handleKeydown = (event) => {
  if (event.key === 'Escape' && !isDeleting.value) {
    closeModal()
  }
}

// Modal açıldığında ESC listener ekle
watch(() => props.isOpen, (isOpen) => {
  if (isOpen) {
    document.addEventListener('keydown', handleKeydown)
    // Body scroll'unu engelle
    document.body.style.overflow = 'hidden'
  } else {
    document.removeEventListener('keydown', handleKeydown)
    // Body scroll'unu geri aç
    document.body.style.overflow = ''
  }
})

// Component unmount olduğunda cleanup
onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
  document.body.style.overflow = ''
})
</script>
