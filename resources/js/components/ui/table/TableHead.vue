<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
  sortable?: boolean
  sortDirection?: 'asc' | 'desc' | null
}>()

const emit = defineEmits<{
  (e: 'sort'): void
}>()

const handleSort = () => {
  if (props.sortable) {
    emit('sort')
  }
}
</script>

<template>
  <th 
    :class="cn(
      'h-12 px-4 text-left align-middle font-semibold text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-800/50',
      {
        'cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700/50 select-none': sortable
      },
      props.class
    )"
    @click="handleSort"
  >
    <div class="flex items-center gap-2">
      <slot />
      <div v-if="sortable" class="flex flex-col">
        <svg 
          class="w-3 h-3 transition-colors"
          :class="{
            'text-blue-600 dark:text-blue-400': sortDirection === 'asc',
            'text-gray-400 dark:text-gray-500': sortDirection !== 'asc'
          }"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
        <svg 
          class="w-3 h-3 -mt-1 transition-colors"
          :class="{
            'text-blue-600 dark:text-blue-400': sortDirection === 'desc',
            'text-gray-400 dark:text-gray-500': sortDirection !== 'desc'
          }"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
  </th>
</template>