<script setup lang="ts">
const props = defineProps<{
  class?: string
}>()
</script>

<template>
  <div :class="[
    'min-h-screen bg-gradient-to-br from-cyan-50 via-blue-100 to-green-100 px-4 py-8 dark:from-gray-950 dark:via-blue-900/30 dark:to-green-900/30',
    props.class
  ]">
    <slot />
  </div>
</template>