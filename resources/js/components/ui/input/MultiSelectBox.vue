<script setup lang="ts">
import { computed, ref, onMounted, onUnmounted, nextTick } from 'vue'
import { FormLabel, InputError } from '@/components/ui/input'
import { ChevronDown, Check, X, Search } from 'lucide-vue-next'

// Renk interface'i için
interface ColorOption {
  id: number
  name: string
  hex_code: string
  disabled?: boolean
}

// Generic option interface'i
interface Option {
  value: string | number
  label: string
  disabled?: boolean
  description?: string
  color?: string
}

interface Props {
  id?: string
  modelValue: (string | number)[]
  options: ColorOption[] | Option[] // Her iki türü de kabul et
  label?: string
  description?: string
  placeholder?: string
  error?: string
  required?: boolean
  disabled?: boolean
  searchable?: boolean
  clearable?: boolean
  size?: 'sm' | 'md' | 'lg'
  variant?: 'default' | 'outline' | 'ghost'
  maxHeight?: string
  showColors?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  id: '',
  placeholder: 'Seçim yapın',
  required: false,
  disabled: false,
  searchable: false,
  clearable: false,
  size: 'md',
  variant: 'default',
  maxHeight: '200px',
  showColors: false
})

const emit = defineEmits<{
  'update:modelValue': [value: (string | number)[]]
  change: [value: (string | number)[]]
  focus: [event: FocusEvent]
  blur: [event: FocusEvent]
  search: [query: string]
}>()

// Reactive state
const isOpen = ref(false)
const searchQuery = ref('')
const selectRef = ref<HTMLDivElement>()
const searchInputRef = ref<HTMLInputElement>()
const optionsRef = ref<HTMLDivElement>()

// Computed properties
const computedId = computed(() => props.id || `multi-select-${Math.random().toString(36).substr(2, 9)}`)

// Options'ları normalize et
const normalizedOptions = computed(() => {
  return props.options.map(option => {
    // Eğer ColorOption formatındaysa dönüştür
    if ('hex_code' in option) {
      return {
        value: option.id,
        label: option.name,
        color: option.hex_code,
        description: option.hex_code,
        disabled: option.disabled || false
      }
    }
    // Zaten Option formatındaysa olduğu gibi döndür
    return option as Option
  })
})

const selectedOptions = computed(() => {
  return normalizedOptions.value.filter(option => props.modelValue.includes(option.value))
})

const filteredOptions = computed(() => {
  if (!props.searchable || !searchQuery.value) {
    return normalizedOptions.value
  }

  return normalizedOptions.value.filter(option =>
    option.label.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    option.description?.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

const displayValue = computed(() => {
  const selected = selectedOptions.value
  if (selected.length === 0) return props.placeholder
  if (selected.length === 1) return selected[0].label
  return `${selected.length} öğe seçildi`
})

const sizeClasses = computed(() => {
  switch (props.size) {
    case 'sm':
      return {
        trigger: 'px-3 py-1.5 text-sm min-h-[32px]',
        option: 'px-3 py-1.5 text-sm',
        search: 'px-3 py-1.5 text-sm',
        tag: 'px-2 py-0.5 text-xs'
      }
    case 'lg':
      return {
        trigger: 'px-4 py-3 text-lg min-h-[48px]',
        option: 'px-4 py-3 text-base',
        search: 'px-4 py-3 text-base',
        tag: 'px-3 py-1 text-sm'
      }
    default:
      return {
        trigger: 'px-3 py-2 text-base min-h-[40px]',
        option: 'px-3 py-2 text-sm',
        search: 'px-3 py-2 text-sm',
        tag: 'px-2 py-1 text-xs'
      }
  }
})

const variantClasses = computed(() => {
  const base = 'w-full rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2'

  switch (props.variant) {
    case 'outline':
      return `${base} border-gray-300 bg-transparent hover:border-gray-400 focus:border-blue-500 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-transparent dark:text-white dark:hover:border-gray-500`
    case 'ghost':
      return `${base} border-transparent bg-gray-50 hover:bg-gray-100 focus:bg-white focus:border-gray-300 focus:ring-gray-500/20 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:bg-gray-900 dark:text-white`
    default:
      return `${base} border-gray-300 bg-white shadow-sm hover:border-gray-400 focus:border-blue-500 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:border-gray-500`
  }
})

const triggerClasses = computed(() => {
  let classes = `${variantClasses.value} ${sizeClasses.value.trigger} flex items-center justify-between cursor-pointer`

  if (props.disabled) {
    classes += ' opacity-50 cursor-not-allowed hover:border-gray-300 dark:hover:border-gray-600'
  }

  if (props.error) {
    classes += ' border-red-500 focus:border-red-500 focus:ring-red-500/20'
  }

  if (isOpen.value && !props.disabled) {
    classes += ' ring-2 ring-blue-500/20 border-blue-500'
  }

  return classes
})

// Methods
const toggleDropdown = () => {
  if (props.disabled) return

  isOpen.value = !isOpen.value

  if (isOpen.value) {
    nextTick(() => {
      if (props.searchable && searchInputRef.value) {
        searchInputRef.value.focus()
      }
    })
  } else {
    searchQuery.value = ''
  }
}

const selectOption = (option: Option, event?: Event) => {
  if (event) {
    event.preventDefault()
    event.stopPropagation()
  }

  if (option.disabled) return

  const currentValues = [...props.modelValue]
  const index = currentValues.indexOf(option.value)

  if (index > -1) {
    currentValues.splice(index, 1)
  } else {
    currentValues.push(option.value)
  }

  emit('update:modelValue', currentValues)
  emit('change', currentValues)
}

const clearSelection = (event: Event) => {
  event.stopPropagation()
  emit('update:modelValue', [])
  emit('change', [])
}

const removeTag = (option: Option, event: Event) => {
  event.stopPropagation()

  const newValues = props.modelValue.filter(value => value !== option.value)
  emit('update:modelValue', newValues)
  emit('change', newValues)
}

const isSelected = (option: Option) => {
  return props.modelValue.includes(option.value)
}

const selectAll = (event?: Event) => {
  if (event) {
    event.preventDefault()
    event.stopPropagation()
  }

  if (props.disabled) return

  const allIds = normalizedOptions.value
    .filter(option => !option.disabled)
    .map(option => option.value)

  emit('update:modelValue', allIds)
  emit('change', allIds)
}

const clearAll = (event?: Event) => {
  if (event) {
    event.preventDefault()
    event.stopPropagation()
  }

  if (props.disabled) return

  emit('update:modelValue', [])
  emit('change', [])
}

const handleClickOutside = (event: Event) => {
  if (selectRef.value && !selectRef.value.contains(event.target as Node)) {
    isOpen.value = false
    searchQuery.value = ''
  }
}

const handleSearch = (event: Event) => {
  const target = event.target as HTMLInputElement
  searchQuery.value = target.value
  emit('search', target.value)
}

// Lifecycle
onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
  <div class="space-y-1">
    <!-- Label -->
    <FormLabel
      v-if="label"
      :for="computedId"
      :label="label"
      :description="description"
      :required="required"
    />

    <!-- Select Container -->
    <div ref="selectRef" class="relative">
      <!-- Trigger -->
      <div
        :id="computedId"
        :class="triggerClasses"
        @click="toggleDropdown"
        @keydown.enter.prevent="toggleDropdown"
        @keydown.space.prevent="toggleDropdown"
        @keydown.escape="isOpen = false"
        tabindex="0"
      >
        <!-- Selected Values Display -->
        <div class="flex-1 flex items-center gap-1 min-w-0">
          <!-- Multiple Selection Tags -->
          <template v-if="selectedOptions.length > 0">
            <div class="flex flex-wrap gap-1">
              <span
                v-for="option in selectedOptions.slice(0, 3)"
                :key="option.value"
                :class="[
                  'inline-flex items-center gap-1 rounded-md',
                  sizeClasses.tag,
                  'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                ]"
              >
                <!-- Color indicator if showColors is true -->
                <span
                  v-if="showColors && option.color"
                  :style="{ backgroundColor: option.color }"
                  class="h-3 w-3 rounded border border-gray-300 dark:border-gray-600"
                ></span>
                {{ option.label }}
                <button
                  type="button"
                  @click="removeTag(option, $event)"
                  class="hover:bg-blue-200 dark:hover:bg-blue-800 rounded-sm p-0.5"
                >
                  <X class="h-3 w-3" />
                </button>
              </span>
              <span
                v-if="selectedOptions.length > 3"
                :class="[
                  'rounded-md',
                  sizeClasses.tag,
                  'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'
                ]"
              >
                +{{ selectedOptions.length - 3 }}
              </span>
            </div>
          </template>

          <!-- Placeholder -->
          <template v-else>
            <span class="text-gray-500 dark:text-gray-400 truncate">
              {{ displayValue }}
            </span>
          </template>
        </div>

        <!-- Right Icons -->
        <div class="flex items-center gap-1 ml-2">
          <!-- Clear Button -->
          <button
            v-if="clearable && selectedOptions.length > 0 && !disabled"
            type="button"
            @click="clearSelection"
            class="p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors"
          >
            <X class="h-4 w-4 text-gray-400" />
          </button>

          <!-- Dropdown Arrow -->
          <ChevronDown
            :class="[
              'h-4 w-4 text-gray-400 transition-transform duration-200',
              isOpen ? 'rotate-180' : ''
            ]"
          />
        </div>
      </div>

      <!-- Dropdown -->
      <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <div
          v-if="isOpen"
          class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg"
        >
          <!-- Search Input -->
          <div v-if="searchable" class="p-2 border-b border-gray-200 dark:border-gray-700">
            <div class="relative">
              <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" />
              <input
                ref="searchInputRef"
                v-model="searchQuery"
                type="text"
                placeholder="Ara..."
                :class="[
                  sizeClasses.search,
                  'w-full pl-10 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500'
                ]"
                @input="handleSearch"
                @keydown.escape="isOpen = false"
              />
            </div>
          </div>

          <!-- Action Buttons -->
          <div v-if="normalizedOptions.length > 0" class="p-2 border-b border-gray-200 dark:border-gray-700 flex justify-between">
            <button
              type="button"
              @click="selectAll"
              :disabled="disabled"
              class="text-xs text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:cursor-not-allowed dark:text-blue-400 dark:hover:text-blue-300"
            >
              Tümünü Seç ({{ normalizedOptions.filter(opt => !opt.disabled).length }})
            </button>
            <button
              type="button"
              @click="clearAll"
              :disabled="disabled || selectedOptions.length === 0"
              class="text-xs text-red-600 hover:text-red-800 disabled:opacity-50 disabled:cursor-not-allowed dark:text-red-400 dark:hover:text-red-300"
            >
              Temizle ({{ selectedOptions.length }})
            </button>
          </div>

          <!-- Options List -->
          <div
            ref="optionsRef"
            :style="{ maxHeight: maxHeight }"
            class="overflow-y-auto py-1"
          >
            <div
              v-for="option in filteredOptions"
              :key="option.value"
              :class="[
                sizeClasses.option,
                'flex items-center gap-3 cursor-pointer transition-colors',
                option.disabled
                  ? 'opacity-50 cursor-not-allowed'
                  : 'hover:bg-gray-50 dark:hover:bg-gray-700',
                isSelected(option)
                  ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300'
                  : 'text-gray-900 dark:text-white'
              ]"
              @click="selectOption(option, $event)"
            >
              <!-- Checkbox -->
              <input
                type="checkbox"
                :checked="isSelected(option)"
                :disabled="option.disabled"
                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 pointer-events-none"
                tabindex="-1"
              />

              <!-- Color Preview (if showColors is true) -->
              <span
                v-if="showColors && option.color"
                :style="{ backgroundColor: option.color }"
                class="h-4 w-4 rounded border border-gray-300 dark:border-gray-600 flex-shrink-0"
                :title="option.color"
              ></span>

              <!-- Option Content -->
              <div class="flex-1 min-w-0">
                <div class="font-medium truncate">{{ option.label }}</div>
                <div v-if="option.description && !showColors" class="text-xs text-gray-500 dark:text-gray-400 truncate">
                  {{ option.description }}
                </div>
                <div v-if="showColors && option.color" class="text-xs text-gray-500 dark:text-gray-400 truncate">
                  {{ option.color }}
                </div>
              </div>

              <!-- Selection Indicator -->
              <Check
                v-if="isSelected(option)"
                class="h-4 w-4 text-blue-600 dark:text-blue-400 flex-shrink-0"
              />
            </div>

            <!-- No Results -->
            <div
              v-if="filteredOptions.length === 0"
              :class="[sizeClasses.option, 'text-gray-500 dark:text-gray-400 text-center']"
            >
              {{ searchQuery ? 'Sonuç bulunamadı' : 'Seçenek yok' }}
            </div>
          </div>
        </div>
      </Transition>
    </div>

    <!-- Error Message -->
    <InputError v-if="error" :message="error" />
  </div>
</template>

<style scoped>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
  width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: rgb(209, 213, 219);
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: rgb(156, 163, 175);
}

.dark .overflow-y-auto::-webkit-scrollbar-thumb {
  background: rgb(75, 85, 99);
}

.dark .overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: rgb(107, 114, 128);
}
</style>