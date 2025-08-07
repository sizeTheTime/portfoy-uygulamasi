<script setup lang="ts">
defineProps<{
  for?: string
  label: string
  description?: string
}>()
</script>

<template>
  <div>
    <label v-if="label" :for="for" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
      {{ label }}
    </label>
    <p v-if="description" class="text-xs text-gray-500 dark:text-gray-400 mb-2">
      {{ description }}
    </p>
  </div>
</template>