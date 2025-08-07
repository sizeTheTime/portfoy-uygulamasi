<script setup lang="ts">
import { FormTextarea, FormLabel, InputError } from '@/components/ui/input';
import { computed } from 'vue';

const props = defineProps<{
  id: string
  label: string
  description?: string
  placeholder?: string
  error?: string
  modelValue: string | number
  textareaProps?: Record<string, any>
}>();

const emit = defineEmits(['update:modelValue']);

const modelValue = computed({
  get() {
    return props.modelValue;
  },
  set(val) {
    emit('update:modelValue', val);
  }
});
</script>

<template>
  <div>
    <FormLabel
      :for="id"
      :label="label"
      :description="description"
    />
    <FormTextarea
      :id="id"
      v-model="modelValue"
      :placeholder="placeholder"
      v-bind="textareaProps"
    />
    <InputError v-if="error" :message="error" />
  </div>
</template>