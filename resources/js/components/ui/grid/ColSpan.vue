<script setup lang="ts">
const props = defineProps<{
  span?: string
  class?: string
}>()
</script>

<template>
  <div :class="[props.span || 'col-span-3 space-y-6', props.class]">
    <slot />
  </div>
</template>