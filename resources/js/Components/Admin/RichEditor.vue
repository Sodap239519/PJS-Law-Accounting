<script setup>
import { watch, onBeforeUnmount } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import LinkExt from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import TextAlign from '@tiptap/extension-text-align';

const props = defineProps({
    modelValue: { type: String, default: '' },
});
const emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit.configure({ link: false, underline: false }),
        Underline,
        LinkExt.configure({ openOnClick: false, autolink: true }),
        Image,
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm max-w-none min-h-[220px] px-4 py-3 focus:outline-none',
        },
    },
    onUpdate: ({ editor }) => emit('update:modelValue', editor.getHTML()),
});

watch(
    () => props.modelValue,
    (val) => {
        if (editor.value && val !== editor.value.getHTML()) {
            editor.value.commands.setContent(val || '', false);
        }
    },
);

onBeforeUnmount(() => editor.value?.destroy());

const setLink = () => {
    const previous = editor.value.getAttributes('link').href;
    const url = window.prompt('ใส่ URL ของลิงก์', previous || 'https://');
    if (url === null) return;
    if (url === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run();
        return;
    }
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
};

const btn = (active) =>
    'px-2 py-1 rounded text-sm border transition ' +
    (active ? 'bg-pjs-blue text-white border-pjs-blue' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50');
</script>

<template>
    <div class="rounded-lg border border-gray-300 bg-white">
        <div v-if="editor" class="flex flex-wrap gap-1 border-b border-gray-200 p-2">
            <button type="button" :class="btn(editor.isActive('bold'))" @click="editor.chain().focus().toggleBold().run()"><b>B</b></button>
            <button type="button" :class="btn(editor.isActive('italic'))" @click="editor.chain().focus().toggleItalic().run()"><i>I</i></button>
            <button type="button" :class="btn(editor.isActive('underline'))" @click="editor.chain().focus().toggleUnderline().run()"><u>U</u></button>
            <span class="mx-1 w-px bg-gray-200"></span>
            <button type="button" :class="btn(editor.isActive('heading', { level: 2 }))" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()">H2</button>
            <button type="button" :class="btn(editor.isActive('heading', { level: 3 }))" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()">H3</button>
            <button type="button" :class="btn(editor.isActive('bulletList'))" @click="editor.chain().focus().toggleBulletList().run()">• รายการ</button>
            <button type="button" :class="btn(editor.isActive('orderedList'))" @click="editor.chain().focus().toggleOrderedList().run()">1. รายการ</button>
            <button type="button" :class="btn(editor.isActive('blockquote'))" @click="editor.chain().focus().toggleBlockquote().run()">❝</button>
            <span class="mx-1 w-px bg-gray-200"></span>
            <button type="button" :class="btn(editor.isActive({ textAlign: 'left' }))" @click="editor.chain().focus().setTextAlign('left').run()">⬅</button>
            <button type="button" :class="btn(editor.isActive({ textAlign: 'center' }))" @click="editor.chain().focus().setTextAlign('center').run()">⬌</button>
            <button type="button" :class="btn(editor.isActive({ textAlign: 'right' }))" @click="editor.chain().focus().setTextAlign('right').run()">➡</button>
            <span class="mx-1 w-px bg-gray-200"></span>
            <button type="button" :class="btn(editor.isActive('link'))" @click="setLink">🔗</button>
            <button type="button" :class="btn(false)" @click="editor.chain().focus().unsetAllMarks().clearNodes().run()">ล้าง</button>
        </div>
        <EditorContent :editor="editor" />
    </div>
</template>
