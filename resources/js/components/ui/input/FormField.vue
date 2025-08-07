

<script setup lang="ts">
import { FormInput, FormLabel, InputError } from '@/components/ui/input';
import { computed } from 'vue';

const props = defineProps<{
  id: string
  label: string
  description?: string
  placeholder?: string
  type?: string
  error?: string
  modelValue: string | number
  inputProps?: Record<string, any>
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
    <FormInput
      :id="id"
      v-model="modelValue"
      :type="type"
      :placeholder="placeholder"
      v-bind="inputProps"
    />
    <InputError v-if="error" :message="error" />
  </div>
</template>