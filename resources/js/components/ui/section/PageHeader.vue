<script setup lang="ts">
import type { Component } from 'vue'

defineProps<{
  icon?: Component
  title: string
  description?: string
}>()
</script>

<template>
  <div class="my-8 text-center">
    <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-700 to-cyan-500">
      <component
        v-if="icon"
        :is="icon"
        class="h-8 w-8 text-white"
      />
      <slot v-else />
    </div>
    <h1 class="mb-2 bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-4xl font-bold text-transparent">
      {{ title }}
    </h1>
    <p class="mx-auto max-w-2xl text-lg text-gray-700 dark:text-gray-200">
      {{ description }}
    </p>
  </div>
</template>