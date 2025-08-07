<script setup lang="ts">
defineProps<{
  message?: string
}>()
</script>

<template>
  <span v-if="message" class="text-sm text-red-600 mt-1 block">
    {{ message }}
  </span>
</template>