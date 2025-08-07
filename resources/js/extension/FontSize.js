// FontSize.js
import { Mark, mergeAttributes } from '@tiptap/core'
import TextStyle from '@tiptap/extension-text-style'

const FontSize = Mark.create({
  name: 'fontSize',

  addOptions() {
    return {
      types: ['textStyle'],
    }
  },

  addAttributes() {
    return {
      fontSize: {
        default: null,
        parseHTML: element => element.style.fontSize,
        renderHTML: attributes => {
          if (!attributes.fontSize) return {}
          return {
            style: `font-size: ${attributes.fontSize}`,
          }
        },
      },
    }
  },

  parseHTML() {
    return [
      {
        style: 'font-size',
      },
    ]
  },

  renderHTML({ HTMLAttributes }) {
    return ['span', mergeAttributes(HTMLAttributes), 0]
  },

  addCommands() {
    return {
      setFontSize:
        fontSize =>
        ({ chain }) => {
          return chain().setMark(this.name, { fontSize }).run()
        },
      unsetFontSize:
        () =>
        ({ chain }) => {
          return chain().unsetMark(this.name).run()
        },
    }
  },
})

export default FontSize
