<script setup lang="ts">
import { ref, computed } from 'vue'
import { Plus, Trash2, Settings, Tag, Hash, ChevronDown } from 'lucide-vue-next'

interface ProductAttribute {
  name: string
  value: string
}

interface Props {
  modelValue: ProductAttribute[]
  errors?: any
}

const props = defineProps<Props>()
const emit = defineEmits<{
  'update:modelValue': [value: ProductAttribute[]]
}>()

// Predefined attribute suggestions
const attributeSuggestions = [
  { name: 'Renk', icon: '🎨' },
  { name: 'Boyut', icon: '📏' },
  { name: 'Materyal', icon: '🧵' },
  { name: 'Marka', icon: '🏷️' },
  { name: 'Model', icon: '📱' },
  { name: 'Ağırlık', icon: '⚖️' },
  { name: 'Garanti', icon: '🛡️' },
  { name: 'Menşei', icon: '🌍' }
]

const showSuggestions = ref(false)

// Methods
const addAttribute = (suggestedName?: string) => {
  const newAttributes = [...props.modelValue]
  newAttributes.push({
    name: suggestedName || '',
    value: '',
  })
  emit('update:modelValue', newAttributes)
  showSuggestions.value = false
}

const removeAttribute = (index: number) => {
  if (props.modelValue.length > 1) {
    const newAttributes = [...props.modelValue]
    newAttributes.splice(index, 1)
    emit('update:modelValue', newAttributes)
  }
}

const updateAttribute = (index: number, field: 'name' | 'value', value: string) => {
  const newAttributes = [...props.modelValue]
  newAttributes[index] = {
    ...newAttributes[index],
    [field]: value
  }
  emit('update:modelValue', newAttributes)
}

const getNestedError = (index: number, field: string): string | undefined => {
  const errorKey = `attributes.${index}.${field}`
  return props.errors?.[errorKey]
}

const attributeCount = computed(() => props.modelValue.length)
const filledAttributesCount = computed(() =>
  props.modelValue.filter(attr => attr.name.trim() && attr.value.trim()).length
)
</script>

<template>
  <div class="space-y-4 sm:space-y-6">
     Mobile-First Header
    <div class="space-y-4">
       Title Section
      <div class="flex items-start gap-3">
        <div class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-lg sm:rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg">
          <Settings class="h-5 w-5 sm:h-6 sm:w-6 text-white" />
        </div>
        <div class="flex-1 min-w-0">
          <h2 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Ürün Özellikleri</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Ürünün teknik özelliklerini belirleyin
          </p>
        </div>
      </div>

       Stats and Add Button
      <div class="flex items-center justify-between gap-3">
         Progress Stats
        <div class="flex items-center gap-2">
          <div class="rounded-lg bg-gray-100 px-3 py-1.5 dark:bg-gray-800">
            <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-300">
              {{ filledAttributesCount }}/{{ attributeCount }}
            </span>
          </div>
          <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:inline">tamamlandı</span>
        </div>

         Add Button with Dropdown
        <div class="relative">
          <button
            type="button"
            @click="showSuggestions = !showSuggestions"
            class="inline-flex items-center gap-2 rounded-lg sm:rounded-xl bg-gradient-to-r from-purple-600 to-purple-700 px-3 py-2 sm:px-4 sm:py-2.5 text-sm font-medium text-white shadow-lg transition-all duration-200 hover:from-purple-700 hover:to-purple-800 active:scale-95 touch-manipulation"
          >
            <Plus class="h-4 w-4" />
            <span class="hidden sm:inline">Özellik Ekle</span>
            <span class="sm:hidden">Ekle</span>
            <ChevronDown :class="['h-3 w-3 transition-transform duration-200', showSuggestions ? 'rotate-180' : '']" />
          </button>

           Mobile-Optimized Suggestions Dropdown
          <div
            v-if="showSuggestions"
            class="absolute right-0 top-full z-20 mt-2 w-72 sm:w-80 rounded-xl border border-gray-200 bg-white p-3 shadow-2xl dark:border-gray-700 dark:bg-gray-800"
          >
            <div class="mb-3 px-1">
              <h3 class="text-sm font-medium text-gray-900 dark:text-white">Önerilen Özellikler</h3>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hızlı ekleme için dokunun</p>
            </div>

             Suggestions Grid - Mobile Optimized
            <div class="grid grid-cols-2 gap-2 mb-3">
              <button
                v-for="suggestion in attributeSuggestions"
                :key="suggestion.name"
                type="button"
                @click="addAttribute(suggestion.name)"
                class="flex items-center gap-2 rounded-lg p-3 text-left text-sm transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 active:bg-gray-200 dark:active:bg-gray-600 touch-manipulation"
              >
                <span class="text-lg">{{ suggestion.icon }}</span>
                <span class="text-gray-700 dark:text-gray-300 font-medium">{{ suggestion.name }}</span>
              </button>
            </div>

             Custom Attribute Button
            <div class="border-t border-gray-200 pt-3 dark:border-gray-700">
              <button
                type="button"
                @click="addAttribute()"
                class="flex w-full items-center gap-2 rounded-lg p-3 text-sm text-gray-600 transition-colors hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 active:bg-gray-200 dark:active:bg-gray-600 touch-manipulation"
              >
                <Plus class="h-4 w-4" />
                <span class="font-medium">Özel özellik ekle</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

     Attributes List - Mobile Optimized
    <div class="space-y-3 sm:space-y-4">
      <div
        v-for="(attribute, index) in modelValue"
        :key="`attribute-${index}`"
        class="group relative rounded-lg sm:rounded-xl border border-gray-200 bg-white p-4 sm:p-6 shadow-sm transition-all duration-200 hover:border-purple-200 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-purple-700"
      >
         Mobile-Friendly Number Badge
        <div class="absolute -left-2 -top-2 sm:-left-3 sm:-top-3 flex h-6 w-6 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-purple-600 text-xs sm:text-sm font-bold text-white shadow-lg">
          {{ index + 1 }}
        </div>

         Mobile-Friendly Remove Button
        <button
          v-if="modelValue.length > 1"
          type="button"
          @click="removeAttribute(index)"
          class="absolute -right-1 -top-1 sm:-right-2 sm:-top-2 flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-red-500 text-white shadow-lg transition-all duration-200 hover:bg-red-600 active:scale-95 touch-manipulation"
          title="Özelliği kaldır"
        >
          <Trash2 class="h-3 w-3 sm:h-4 sm:w-4" />
        </button>

         Mobile-First Form Layout
        <div class="space-y-4">
           Attribute Name
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <Tag class="h-4 w-4 text-purple-500" />
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Özellik Adı
                <span class="text-red-500">*</span>
              </label>
            </div>
            <input
              :value="attribute.name"
              @input="updateAttribute(index, 'name', ($event.target as HTMLInputElement).value)"
              type="text"
              placeholder="örn: Renk, Boyut, Materyal"
              class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm transition-all duration-200 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-purple-400 touch-manipulation"
            />
            <p v-if="getNestedError(index, 'name')" class="text-xs text-red-600 dark:text-red-400">
              {{ getNestedError(index, 'name') }}
            </p>
          </div>

           Attribute Value
          <div class="space-y-2">
            <div class="flex items-center gap-2">
              <Hash class="h-4 w-4 text-purple-500" />
              <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Özellik Değeri
                <span class="text-red-500">*</span>
              </label>
            </div>
            <input
              :value="attribute.value"
              @input="updateAttribute(index, 'value', ($event.target as HTMLInputElement).value)"
              type="text"
              placeholder="örn: Kırmızı, XL, Pamuk"
              class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm transition-all duration-200 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-purple-400 touch-manipulation"
            />
            <p v-if="getNestedError(index, 'value')" class="text-xs text-red-600 dark:text-red-400">
              {{ getNestedError(index, 'value') }}
            </p>
          </div>
        </div>

         Mobile-Optimized Completion Indicator
        <div class="mt-4 flex items-center gap-3">
          <div class="flex-1 h-1.5 bg-gray-200 rounded-full dark:bg-gray-700">
            <div
              :class="[
                'h-1.5 rounded-full transition-all duration-300',
                attribute.name.trim() && attribute.value.trim()
                  ? 'w-full bg-gradient-to-r from-green-500 to-green-600'
                  : attribute.name.trim() || attribute.value.trim()
                    ? 'w-1/2 bg-gradient-to-r from-yellow-500 to-yellow-600'
                    : 'w-0'
              ]"
            ></div>
          </div>
          <span
            :class="[
              'text-xs font-medium whitespace-nowrap',
              attribute.name.trim() && attribute.value.trim()
                ? 'text-green-600 dark:text-green-400'
                : attribute.name.trim() || attribute.value.trim()
                  ? 'text-yellow-600 dark:text-yellow-400'
                  : 'text-gray-400'
            ]"
          >
            {{
              attribute.name.trim() && attribute.value.trim()
                ? '✓ Tamam'
                : attribute.name.trim() || attribute.value.trim()
                  ? 'Devam'
                  : 'Boş'
            }}
          </span>
        </div>
      </div>

       Mobile-Optimized Empty State
      <div v-if="modelValue.length === 0" class="rounded-lg sm:rounded-xl border-2 border-dashed border-gray-300 p-8 sm:p-12 text-center dark:border-gray-600">
        <Settings class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" />
        <h3 class="mt-3 sm:mt-4 text-base sm:text-lg font-medium text-gray-900 dark:text-white">Henüz özellik eklenmedi</h3>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 px-4">
          Ürününüzün özelliklerini ekleyerek müşterilerinize daha detaylı bilgi verin
        </p>
        <button
          type="button"
          @click="addAttribute()"
          class="mt-4 inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-3 text-sm font-medium text-white transition-colors hover:bg-purple-700 active:scale-95 touch-manipulation"
        >
          <Plus class="h-4 w-4" />
          İlk özelliği ekle
        </button>
      </div>
    </div>

     Mobile-Optimized Help Text
    <div class="rounded-lg bg-purple-50 p-4 dark:bg-purple-900/20">
      <div class="flex items-start gap-3">
        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800 flex-shrink-0">
          <Settings class="h-3 w-3 text-purple-600 dark:text-purple-400" />
        </div>
        <div class="flex-1 min-w-0">
          <h4 class="text-sm font-medium text-purple-900 dark:text-purple-100">İpucu</h4>
          <p class="mt-1 text-sm text-purple-700 dark:text-purple-300 leading-relaxed">
            Ürün özelliklerini eklerken müşterilerinizin aradığı bilgileri düşünün.
            <span class="hidden sm:inline">Renk, boyut, materyal gibi temel özellikler satış oranınızı artırabilir.</span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
