<template>
                            <SectionBox >

  <div class="flex justify-end space-x-4 border-t border-gray-200 pt-6 dark:border-gray-400">
    <button
      type="button"
      class="rounded-md border border-gray-300 px-6 py-2 text-gray-700 transition-colors hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-800"
      @click="$emit('cancel')"
    >
      <slot name="cancel">İptal</slot>
    </button>
    <button
      type="submit"
      :disabled="processing"
      class="rounded-md bg-gradient-to-r from-gray-600 to-green-500 px-6 py-2 text-white transition-all duration-200 hover:from-gray-700 hover:to-green-400 disabled:cursor-not-allowed disabled:opacity-50"
    >
      <span v-if="processing">
        <slot name="processing">Kaydediliyor...</slot>
      </span>
      <span v-else>
        <slot name="submit">Ürünü Kaydet</slot>
      </span>
    </button>
  </div>
  </SectionBox>
</template>

<script setup lang="ts">
import {SectionBox} from '@/components/ui/section';
defineProps<{
  processing?: boolean
}>();
defineEmits(['cancel']);
</script>