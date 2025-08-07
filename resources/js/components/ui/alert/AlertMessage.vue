<template>
  <div v-if="message" class="mb-6">
    <div
      class="rounded px-4 py-3"
      :class="{
        'border border-green-300 bg-green-100 text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-100': type === 'success',
        'border border-red-300 bg-red-100 text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-100': type === 'error',
      }"
    >
      {{ message }}
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  message: string;
  type: 'success' | 'error' | '';
}>();
</script>