<template>
    <div class="tiptap-editor">
        <!-- Toolbar -->
        <div class="toolbar border border-border border-b-0 rounded-t-md bg-muted/50 dark:bg-muted/20 p-2 flex flex-wrap gap-1">
            <!-- Text Formatting -->
            <button
                type="button"
                @click="toggleBold"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('bold') }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Bold"
                :disabled="!editor"
            >
                <Bold :size="16" />
            </button>

            <button
                type="button"
                @click="toggleItalic"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('italic') }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Italic"
                :disabled="!editor"
            >
                <Italic :size="16" />
            </button>

            <button
                type="button"
                @click="toggleUnderline"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('underline') }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Underline"
                :disabled="!editor"
            >
                <UnderlineIcon :size="16" />
            </button>

            <button
                type="button"
                @click="toggleStrike"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('strike') }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Strikethrough"
                :disabled="!editor"
            >
                <Strikethrough :size="16" />
            </button>

            <div class="w-px h-6 bg-border/50 dark:bg-border/30 mx-1"></div>

            <!-- Font Size Dropdown -->
            <div class="relative">
                <select
                    @change="setFontSize($event.target.value)"
                    class="p-2 rounded border border-border text-sm bg-background hover:bg-muted/30"
                    :disabled="!editor"
                >
                    <option value="">Font Size</option>
                    <option value="12px">12px</option>
                    <option value="14px">14px</option>
                    <option value="16px">16px</option>
                    <option value="18px">18px</option>
                    <option value="20px">20px</option>
                    <option value="24px">24px</option>
                    <option value="28px">28px</option>
                    <option value="32px">32px</option>
                    <option value="36px">36px</option>
                    <option value="48px">48px</option>
                </select>
            </div>

            <!-- Color Picker -->
            <div class="relative">
                <input
                    type="color"
                    @change="setColor($event.target.value)"
                    class="w-8 h-8 rounded border border-border cursor-pointer"
                    title="Text Color"
                    :disabled="!editor"
                />
            </div>

            <div class="w-px h-6 bg-border/50 dark:bg-border/30 mx-1"></div>

            <!-- Headings -->
            <button
                type="button"
                @click="toggleHeading1"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('customHeading', { level: 1 }) }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors font-bold text-sm"
                title="Heading 1"
                :disabled="!editor"
            >
                H1
            </button>

            <button
                type="button"
                @click="toggleHeading2"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('customHeading', { level: 2 }) }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors font-bold text-sm"
                title="Heading 2"
                :disabled="!editor"
            >
                H2
            </button>

            <button
                type="button"
                @click="toggleHeading3"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('customHeading', { level: 3 }) }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors font-bold text-sm"
                title="Heading 3"
                :disabled="!editor"
            >
                H3
            </button>

            <div class="w-px h-6 bg-border/50 dark:bg-border/30 mx-1"></div>

            <!-- Lists -->
            <button
                type="button"
                @click="toggleBulletList"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('bulletList') }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Bullet List"
                :disabled="!editor"
            >
                <List :size="16" />
            </button>

            <button
                type="button"
                @click="toggleOrderedList"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('orderedList') }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Numbered List"
                :disabled="!editor"
            >
                <ListOrdered :size="16" />
            </button>

            <div class="w-px h-6 bg-border/50 dark:bg-border/30 mx-1"></div>

            <!-- Alignment -->
            <button
                type="button"
                @click="setTextAlignLeft"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive({ textAlign: 'left' }) }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Align Left"
                :disabled="!editor"
            >
                <AlignLeft :size="16" />
            </button>

            <button
                type="button"
                @click="setTextAlignCenter"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive({ textAlign: 'center' }) }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Align Center"
                :disabled="!editor"
            >
                <AlignCenter :size="16" />
            </button>

            <button
                type="button"
                @click="setTextAlignRight"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive({ textAlign: 'right' }) }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Align Right"
                :disabled="!editor"
            >
                <AlignRight :size="16" />
            </button>

            <div class="w-px h-6 bg-border/50 dark:bg-border/30 mx-1"></div>

            <!-- Quote and Code -->
            <button
                type="button"
                @click="toggleBlockquote"
                :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('blockquote') }"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                title="Quote"
                :disabled="!editor"
            >
                <Quote :size="16" />
            </button>

            <div class="w-px h-6 bg-border/50 dark:bg-border/30 mx-1"></div>

            <!-- Undo/Redo -->
            <button
                type="button"
                @click="undo"
                :disabled="!editor?.can().undo()"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                title="Undo"
            >
                <Undo :size="16" />
            </button>

            <button
                type="button"
                @click="redo"
                :disabled="!editor?.can().redo()"
                class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                title="Redo"
            >
                <Redo :size="16" />
            </button>

            <div class="relative">
                <input
                    type="file"
                    ref="imageInput"
                    @change="uploadImage"
                    accept="image/*"
                    class="hidden"
                />
                <button
                    type="button"
                    @click="$refs.imageInput.click()"
                    class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
                    title="Upload Image"
                    :disabled="!editor"
                >
                    <ImageIcon :size="16" />
                </button>
            </div>
        </div>

        <!-- Editor Content -->
        <div
            ref="editorRef"
            class="prose prose-sm max-w-none border border-border rounded-b-md p-4 min-h-[200px] bg-background"
            :class="{ 'border-destructive': error }"
        ></div>

        <!-- Error Message -->
        <p v-if="error" class="mt-1 text-sm text-destructive">{{ error }}</p>
    </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount, watch, nextTick } from 'vue'
import { Editor } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import Color from '@tiptap/extension-color'
import { TextStyle } from '@tiptap/extension-text-style'
import Placeholder from '@tiptap/extension-placeholder'
import FontSize from './extensions/FontSize.js'
import CustomHeading from './extensions/CustomHeading.js'
import Image from '@tiptap/extension-image'

import {
    Bold,
    Italic,
    Underline as UnderlineIcon,
    Strikethrough,
    List,
    ListOrdered,
    AlignLeft,
    AlignCenter,
    AlignRight,
    Quote,
    Code,
    Undo,
    Redo,
        Image as ImageIcon
} from 'lucide-vue-next'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: null
    },
    placeholder: {
        type: String,
        default: 'İçeriğinizi buraya yazın...'
    }
})

const emit = defineEmits(['update:modelValue'])

const editorRef = ref(null)
const editor = ref(null)

onMounted(async () => {
    await nextTick()

    editor.value = new Editor({
        element: editorRef.value,
        extensions: [
            StarterKit.configure({
                heading: false, // Custom heading kullanacağız
            }),
            CustomHeading.configure({
                levels: [1, 2, 3, 4, 5, 6],
            }),
            Underline,
            TextStyle,
            Color,
            FontSize,
            Image,
            TextAlign.configure({
                types: ['customHeading', 'paragraph'],
            }),
            Placeholder.configure({
                placeholder: props.placeholder,
            }),
        ],
        content: props.modelValue,
        editorProps: {
            attributes: {
                class: 'prose prose-sm max-w-none focus:outline-none min-h-[150px]',
            },
        },
        onUpdate: ({ editor }) => {
            emit('update:modelValue', editor.getHTML())
        },
    })
})

onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy()
    }
})

watch(() => props.modelValue, (newValue) => {
    if (editor.value && editor.value.getHTML() !== newValue) {
        editor.value.commands.setContent(newValue, false)
    }
})

// Command methods
const toggleBold = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleBold().run()
    }
}

const toggleItalic = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleItalic().run()
    }
}

const toggleUnderline = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleUnderline().run()
    }
}

const toggleStrike = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleStrike().run()
    }
}

const setFontSize = (size) => {
    if (editor.value && size) {
        editor.value.chain().focus().setFontSize(size).run()
    }
}

const setColor = (color) => {
    if (editor.value && color) {
        editor.value.chain().focus().setColor(color).run()
    }
}

const toggleHeading1 = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleCustomHeading({ level: 1 }).run()
    }
}

const toggleHeading2 = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleCustomHeading({ level: 2 }).run()
    }
}

const toggleHeading3 = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleCustomHeading({ level: 3 }).run()
    }
}

const toggleBulletList = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleBulletList().run()
    }
}

const toggleOrderedList = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleOrderedList().run()
    }
}

const setTextAlignLeft = () => {
    if (editor.value) {
        editor.value.chain().focus().setTextAlign('left').run()
    }
}

const setTextAlignCenter = () => {
    if (editor.value) {
        editor.value.chain().focus().setTextAlign('center').run()
    }
}

const setTextAlignRight = () => {
    if (editor.value) {
        editor.value.chain().focus().setTextAlign('right').run()
    }
}

const toggleBlockquote = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleBlockquote().run()
    }
}

const toggleCode = () => {
    if (editor.value) {
        editor.value.chain().focus().toggleCode().run()
    }
}

const undo = () => {
    if (editor.value) {
        editor.value.chain().focus().undo().run()
    }
}

const redo = () => {
    if (editor.value) {
        editor.value.chain().focus().redo().run()
    }
}


const uploadImage = async (event) => {
    if (!editor.value || !event.target.files || !event.target.files.length) return;

    const file = event.target.files[0];

    try {
        const formData = new FormData();
        formData.append('image', file);

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const response = await axios.post('/blogs/upload-image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': token
            }
        });

        // Resmi editöre ekle
        editor.value.chain().focus().setImage({ src: response.data.url, alt: file.name }).run();
    } catch (error) {
        console.error('Error uploading image:', error);
    } finally {
        event.target.value = '';
    }
};

</script>

<style scoped>

</style>
