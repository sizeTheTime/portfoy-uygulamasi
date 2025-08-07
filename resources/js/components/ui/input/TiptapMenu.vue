<template>
    <div class="toolbar border border-border rounded-t-md bg-muted/50 dark:bg-muted/20 p-2 flex flex-wrap gap-1">
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
        <FontSizeDropdown :editor="editor" />

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

        <!-- Color Picker -->
        <TiptapColor :editor="editor" />

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

        <button
            type="button"
            @click="toggleCode"
            :class="{ 'bg-primary/10 text-primary dark:bg-primary/20': editor?.isActive('code') }"
            class="p-2 rounded hover:bg-muted dark:hover:bg-muted/50 transition-colors"
            title="Inline Code"
            :disabled="!editor"
        >
            <Code :size="16" />
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
    </div>
</template>

<script setup>
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
    Redo
} from 'lucide-vue-next'
import FontSizeDropdown from './FontSizeDropdown.vue'
import TiptapColor from './TiptapColor.vue'

const props = defineProps({
    editor: {
        type: Object,
        required: true
    }
})

// Command methods
const toggleBold = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleBold().run()
    }
}

const toggleItalic = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleItalic().run()
    }
}

const toggleUnderline = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleUnderline().run()
    }
}

const toggleStrike = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleStrike().run()
    }
}

const toggleHeading1 = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleCustomHeading({ level: 1 }).run()
    }
}

const toggleHeading2 = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleCustomHeading({ level: 2 }).run()
    }
}

const toggleHeading3 = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleCustomHeading({ level: 3 }).run()
    }
}

const toggleBulletList = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleBulletList().run()
    }
}

const toggleOrderedList = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleOrderedList().run()
    }
}

const setTextAlignLeft = () => {
    if (props.editor) {
        props.editor.chain().focus().setTextAlign('left').run()
    }
}

const setTextAlignCenter = () => {
    if (props.editor) {
        props.editor.chain().focus().setTextAlign('center').run()
    }
}

const setTextAlignRight = () => {
    if (props.editor) {
        props.editor.chain().focus().setTextAlign('right').run()
    }
}

const toggleBlockquote = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleBlockquote().run()
    }
}

const toggleCode = () => {
    if (props.editor) {
        props.editor.chain().focus().toggleCode().run()
    }
}

const undo = () => {
    if (props.editor) {
        props.editor.chain().focus().undo().run()
    }
}

const redo = () => {
    if (props.editor) {
        props.editor.chain().focus().redo().run()
    }
}
</script>
