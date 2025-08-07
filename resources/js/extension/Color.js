import { Mark } from '@tiptap/core';

const Color = Mark.create({
  name: 'color',

  addOptions() {
    return {
      types: ['textStyle'],
    };
  },

  addAttributes() {
    return {
      color: {
        default: null,
        parseHTML: element => element.style.color,
        renderHTML: attributes => {
          if (!attributes.color) return {};
          return { style: `color: ${attributes.color}` };
        },
      },
    };
  },

  parseHTML() {
    return [{ style: 'color' }];
  },

  renderHTML({ HTMLAttributes }) {
    return ['span', HTMLAttributes, 0];
  },

  addCommands() {
    return {
      setColor: color => ({ chain }) => {
        return chain().setMark(this.name, { color }).run();
      },
      unsetColor: () => ({ chain }) => {
        return chain().unsetMark(this.name).run();
      },
    };
  },
});

export default Color;
