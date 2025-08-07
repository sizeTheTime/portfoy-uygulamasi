<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
  clickable?: boolean
  selected?: boolean
}>()

const emit = defineEmits<{
  (e: 'click', event: MouseEvent): void
}>()

const handleClick = (event: MouseEvent) => {
  if (props.clickable) {
    emit('click', event)
  }
}
</script>

<template>
  <tr 
    :class="cn(
      'border-b border-gray-200 dark:border-gray-700 transition-colors',
      {
        'hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer': clickable,
        'bg-blue-50 dark:bg-blue-950/20 border-blue-200 dark:border-blue-800': selected,
        'data-[state=selected]:bg-muted': selected
      },
      props.class
    )"
    @click="handleClick"
  >
    <slot />
  </tr>
</template>