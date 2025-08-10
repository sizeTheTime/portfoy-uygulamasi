<script setup lang="ts">
const props = defineProps<{
  class?: string
  grid?: string
}>()
</script>

<template>
  <div :class="[props.grid || 'grid grid-cols-1 gap-2 md:gap-8 lg:grid-cols-5', props.class]">
    <slot />
  </div>
</template>