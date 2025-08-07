<script setup lang="ts">
defineProps<{
  loading?: boolean
  disabled?: boolean
  label?: string
  loadingLabel?: string
}>()
</script>

<template>
  <button
    type="submit"
    :disabled="disabled || loading"
    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
  >
    <span v-if="loading" class="flex items-center">
      <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      {{ loadingLabel || 'Oluşturuluyor...' }}
    </span>
    <span v-else>
      {{ label || 'Kaydet' }}
    </span>
  </button>
</template>