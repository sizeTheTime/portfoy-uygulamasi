<script setup lang="ts">
import { ref, computed } from 'vue'
import { Plus, Trash2, Settings, Tag, Hash } from 'lucide-vue-next'

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
  <div class="space-y-6">
    <!-- Header with Stats -->
    <div class="flex flex-col md:flex-row  items-center justify-between">
      <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg">
          <Settings class="h-6 w-6 text-white" />
        </div>
        <div>
          <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Ürün Özellikleri</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400">
            Ürünün teknik özelliklerini ve detaylarını belirleyin
          </p>
        </div>
      </div>

      <!-- Stats Badge -->
      <div class="flex items-center gap-3">
        <div class="hidden md:block rounded-lg bg-gray-100 px-3 py-1.5 dark:bg-gray-800">
          <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
            {{ filledAttributesCount }}/{{ attributeCount }} tamamlandı
          </span>
        </div>

        <!-- Add Button with Dropdown -->
        <div class="relative">
          <button
            type="button"
            @click="showSuggestions = !showSuggestions"
            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-purple-600 to-purple-700 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all duration-200 hover:from-purple-700 hover:to-purple-800 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-purple-500/20"
          >
            <Plus class="h-4 w-4" />
            Özellik Ekle
          </button>

          <!-- Suggestions Dropdown -->
          <div
            v-if="showSuggestions"
            class="absolute right-0 top-full z-10 mt-2 w-64 rounded-xl border border-gray-200 bg-white p-2 shadow-xl dark:border-gray-700 dark:bg-gray-800"
          >
            <div class="mb-2 px-3 py-2">
              <h3 class="text-sm font-medium text-gray-900 dark:text-white">Önerilen Özellikler</h3>
              <p class="text-xs text-gray-500 dark:text-gray-400">Hızlı ekleme için tıklayın</p>
            </div>

            <div class="grid grid-cols-2 gap-1">
              <button
                v-for="suggestion in attributeSuggestions"
                :key="suggestion.name"
                type="button"
                @click="addAttribute(suggestion.name)"
                class="flex items-center gap-2 rounded-lg p-2 text-left text-sm transition-colors hover:bg-gray-100 dark:hover:bg-gray-700"
              >
                <span class="text-base">{{ suggestion.icon }}</span>
                <span class="text-gray-700 dark:text-gray-300">{{ suggestion.name }}</span>
              </button>
            </div>

            <div class="mt-2 border-t border-gray-200 pt-2 dark:border-gray-700">
              <button
                type="button"
                @click="addAttribute()"
                class="flex w-full items-center gap-2 rounded-lg p-2 text-sm text-gray-600 transition-colors hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700"
              >
                <Plus class="h-4 w-4" />
                Özel özellik ekle
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Attributes List -->
    <div class="space-y-4">
      <div
        v-for="(attribute, index) in modelValue"
        :key="`attribute-${index}`"
        class="group relative rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 hover:border-purple-200 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:hover:border-purple-700"
      >
        <!-- Attribute Number Badge -->
        <div class="absolute -left-3 -top-3 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-purple-600 text-sm font-bold text-white shadow-lg">
          {{ index + 1 }}
        </div>

        <!-- Remove Button -->
        <button
          v-if="modelValue.length > 1"
          type="button"
          @click="removeAttribute(index)"
          class="absolute -right-2 -top-2 flex h-8 w-8 items-center justify-center rounded-full bg-red-500 text-white opacity-0 shadow-lg transition-all duration-200 hover:bg-red-600 group-hover:opacity-100"
          title="Özelliği kaldır"
        >
          <Trash2 class="h-4 w-4" />
        </button>

        <!-- Attribute Form -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <!-- Attribute Name -->
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
              class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm transition-all duration-200 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-purple-400"
            />
            <p v-if="getNestedError(index, 'name')" class="text-xs text-red-600 dark:text-red-400">
              {{ getNestedError(index, 'name') }}
            </p>
          </div>

          <!-- Attribute Value -->
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
              class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm transition-all duration-200 focus:border-purple-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-purple-400"
            />
            <p v-if="getNestedError(index, 'value')" class="text-xs text-red-600 dark:text-red-400">
              {{ getNestedError(index, 'value') }}
            </p>
          </div>
        </div>

        <!-- Completion Indicator -->
        <div class="mt-4 flex items-center gap-2">
          <div class="flex-1 h-1 bg-gray-200 rounded-full dark:bg-gray-700">
            <div
              :class="[
                'h-1 rounded-full transition-all duration-300',
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
              'text-xs font-medium',
              attribute.name.trim() && attribute.value.trim()
                ? 'text-green-600 dark:text-green-400'
                : attribute.name.trim() || attribute.value.trim()
                  ? 'text-yellow-600 dark:text-yellow-400'
                  : 'text-gray-400'
            ]"
          >
            {{
              attribute.name.trim() && attribute.value.trim()
                ? 'Tamamlandı'
                : attribute.name.trim() || attribute.value.trim()
                  ? 'Devam ediyor'
                  : 'Başlanmadı'
            }}
          </span>
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="modelValue.length === 0" class="rounded-xl border-2 border-dashed border-gray-300 p-12 text-center dark:border-gray-600">
        <Settings class="mx-auto h-12 w-12 text-gray-400" />
        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Henüz özellik eklenmedi</h3>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
          Ürününüzün özelliklerini ekleyerek müşterilerinize daha detaylı bilgi verin
        </p>
        <button
          type="button"
          @click="addAttribute()"
          class="mt-4 inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-purple-700"
        >
          <Plus class="h-4 w-4" />
          İlk özelliği ekle
        </button>
      </div>
    </div>

    <!-- Help Text -->
    <div class="rounded-lg bg-purple-50 p-4 dark:bg-purple-900/20">
      <div class="flex items-start gap-3">
        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-800">
          <Settings class="h-3 w-3 text-purple-600 dark:text-purple-400" />
        </div>
        <div class="flex-1">
          <h4 class="text-sm font-medium text-purple-900 dark:text-purple-100">İpucu</h4>
          <p class="mt-1 text-sm text-purple-700 dark:text-purple-300">
            Ürün özelliklerini eklerken müşterilerinizin aradığı bilgileri düşünün.
            Renk, boyut, materyal gibi temel özellikler satış oranınızı artırabilir.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>