<script setup lang="ts">
import type { Component } from 'vue'
defineProps<{
  title: string
  description?: string
  icon?: Component
}>()
</script>

<template>
  <div class="border-b border-gray-100 p-2 md:p-6 pb-4 dark:border-gray-800 ">
    <div class="flex items-center gap-3">
      <div class="flex min-h-10 min-w-10 items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 to-cyan-500">
        <component v-if="icon" :is="icon" class="w-5 h-5 text-white" />
      </div>
      <div>
        <h2 class="text-base md:text-xl font-semibold text-gray-900 dark:text-white">{{ title }}</h2>
        <p v-if="description" class="text-sm text-gray-600 dark:text-gray-400">{{ description }}</p>
      </div>
    </div>
  </div>
</template>