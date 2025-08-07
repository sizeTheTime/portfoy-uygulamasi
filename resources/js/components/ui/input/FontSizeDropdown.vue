<template>
    <div class="relative">
        <button
            type="button"
            @click="toggleDropdown"
            class="p-2 rounded hover:bg-gray-200 transition-colors flex items-center gap-1"
            title="Font Size"
            :disabled="!editor"
        >
            <Type :size="16" />
            <span class="text-xs">{{ currentFontSize }}</span>
            <ChevronDown :size="12" />
        </button>

        <div
            v-if="isOpen"
            class="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-50 min-w-[120px]"
        >
            <div class="py-1">
                <button
                    v-for="size in fontSizes"
                    :key="size.value"
                    type="button"
                    @click="setFontSize(size.value)"
                    :class="{
                        'bg-blue-100 text-blue-600': currentFontSize === size.label
                    }"
                    class="w-full text-left px-3 py-2 hover:bg-gray-100 transition-colors"
                >
                    <span :style="{ fontSize: size.value }">{{ size.label }}</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Type, ChevronDown } from 'lucide-vue-next'

const props = defineProps({
    editor: {
        type: Object,
        required: true
    }
})

const isOpen = ref(false)

const fontSizes = [
    { label: '12px', value: '12px' },
    { label: '14px', value: '14px' },
    { label: '16px', value: '16px' },
    { label: '18px', value: '18px' },
    { label: '20px', value: '20px' },
    { label: '24px', value: '24px' },
    { label: '28px', value: '28px' },
    { label: '32px', value: '32px' },
    { label: '36px', value: '36px' },
    { label: '48px', value: '48px' }
]

const currentFontSize = computed(() => {
    if (!props.editor) return '16px'

    const fontSize = props.editor.getAttributes('textStyle').fontSize
    if (!fontSize) return '16px'

    const found = fontSizes.find(size => size.value === fontSize)
    return found ? found.label : fontSize
})

const toggleDropdown = () => {
    isOpen.value = !isOpen.value
}

const setFontSize = (size) => {
    if (props.editor) {
        props.editor.chain().focus().setFontSize(size).run()
    }
    isOpen.value = false
}

const closeDropdown = (event) => {
    if (!event.target.closest('.relative')) {
        isOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', closeDropdown)
})

onUnmounted(() => {
    document.removeEventListener('click', closeDropdown)
})
</script>
