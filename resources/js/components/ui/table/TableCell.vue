<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
  align?: 'left' | 'center' | 'right'
}>()

const alignmentClass = {
  left: 'text-left',
  center: 'text-center',
  right: 'text-right'
}
</script>

<template>
  <td
    :class="cn(
      'p-4 align-middle text-gray-900 dark:text-gray-100 max-w-sm',
      alignmentClass[align || 'left'],
      props.class
    )"
  >
    <slot />
  </td>
</template>