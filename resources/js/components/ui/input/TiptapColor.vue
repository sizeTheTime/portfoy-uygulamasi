<template>
    <div class="relative">
        <button
            type="button"
            @click="toggleColorPicker"
            class="p-2 rounded hover:bg-gray-200 transition-colors flex items-center gap-1"
            title="Text Color"
            :disabled="!editor"
        >
            <Palette :size="16" />
            <div
                class="w-4 h-1 rounded"
                :style="{ backgroundColor: currentColor }"
            ></div>
        </button>

        <div
            v-if="isOpen"
            class="absolute top-full left-0 mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-50 p-3"
        >
            <div class="grid grid-cols-8 gap-1 mb-3">
                <button
                    v-for="color in predefinedColors"
                    :key="color"
                    type="button"
                    @click="setColor(color)"
                    :class="{
                        'ring-2 ring-blue-500': currentColor === color
                    }"
                    class="w-6 h-6 rounded border border-gray-300 hover:scale-110 transition-transform"
                    :style="{ backgroundColor: color }"
                    :title="color"
                ></button>
            </div>

            <div class="flex items-center gap-2 mb-2">
                <input
                    type="color"
                    v-model="customColor"
                    @change="setColor(customColor)"
                    class="w-8 h-8 rounded border border-gray-300 cursor-pointer"
                />
                <span class="text-sm text-gray-600">Custom</span>
            </div>

            <button
                type="button"
                @click="removeColor"
                class="w-full text-left px-2 py-1 text-sm text-gray-600 hover:bg-gray-100 rounded"
            >
                Remove Color
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Palette } from 'lucide-vue-next'

const props = defineProps({
    editor: {
        type: Object,
        required: true
    }
})

const isOpen = ref(false)
const customColor = ref('#000000')

const predefinedColors = [
    '#000000', '#434343', '#666666', '#999999', '#b7b7b7', '#cccccc', '#d9d9d9', '#efefef',
    '#f3f3f3', '#ffffff', '#980000', '#ff0000', '#ff9900', '#ffff00', '#00ff00', '#00ffff',
    '#4a86e8', '#0000ff', '#9900ff', '#ff00ff', '#e6b8af', '#f4cccc', '#fce5cd', '#fff2cc',
    '#d9ead3', '#d0e0e3', '#c9daf8', '#cfe2f3', '#d9d2e9', '#ead1dc', '#dd7e6b', '#ea9999',
    '#f9cb9c', '#ffe599', '#b6d7a8', '#a2c4c9', '#a4c2f4', '#9fc5e8', '#b4a7d6', '#d5a6bd'
]

const currentColor = computed(() => {
    if (!props.editor) return '#000000'

    const color = props.editor.getAttributes('textStyle').color
    return color || '#000000'
})

const toggleColorPicker = () => {
    isOpen.value = !isOpen.value
}

const setColor = (color) => {
    if (props.editor) {
        props.editor.chain().focus().setColor(color).run()
    }
    isOpen.value = false
}

const removeColor = () => {
    if (props.editor) {
        props.editor.chain().focus().unsetColor().run()
    }
    isOpen.value = false
}

const closeColorPicker = (event) => {
    if (!event.target.closest('.relative')) {
        isOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', closeColorPicker)
})

onUnmounted(() => {
    document.removeEventListener('click', closeColorPicker)
})
</script>
