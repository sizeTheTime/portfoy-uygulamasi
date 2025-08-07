import { Heading } from '@tiptap/extension-heading';

const CustomHeading = Heading.extend({
  renderHTML({ node, HTMLAttributes }) {
    const level = node.attrs.level;
    const baseClass = level === 1
      ? 'text-2xl font-bold text-[#121010]' 
      : level === 2
      ? 'text-xl font-semibold text-[#121010]'
      : 'text-lg font-medium text-[#121010]';
    return ['h' + level, { ...HTMLAttributes, class: baseClass }, 0];
  }
});

export default CustomHeading