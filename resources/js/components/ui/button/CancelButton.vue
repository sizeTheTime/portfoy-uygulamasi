<script setup lang="ts">
defineProps<{
  to?: string
}>()
const goBack = () => {
  if (history.length > 1) window.history.back()
}
</script>

<template>
  <button
    type="button"
    @click="to ? $router.push(to) : goBack()"
    class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 font-medium transition duration-200"
  >
    <slot>İptal</slot>
  </button>
</template>