<script setup lang="ts">
const props = defineProps<{
  class?: string
}>()
</script>

<template>
  <div :class="['space-y-4 rounded-2xl bg-white p-6 shadow-md dark:bg-gray-900', props.class]">
    <slot />
  </div>
</template>