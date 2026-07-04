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
        Image.configure({ inline: false, HTMLAttributes: { class: 'rounded-lg' } }),
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm max-w-none min-h-[240px] px-4 py-3 focus:outline-none prose-blockquote:border-pjs-blue prose-blockquote:text-slate-600 prose-a:text-pjs-blue',
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

const addImage = () => {
    const url = window.prompt('ใส่ URL ของรูปภาพ', 'https://');
    if (url) editor.value.chain().focus().setImage({ src: url }).run();
};

const btn = (active) =>
    'flex h-8 min-w-8 items-center justify-center rounded-lg px-2 text-sm transition ' +
    (active ? 'bg-pjs-blue text-white' : 'text-slate-600 hover:bg-slate-100');
</script>

<template>
    <div class="overflow-hidden rounded-xl border border-slate-300 bg-white">
        <div v-if="editor" class="flex flex-wrap items-center gap-0.5 border-b border-slate-200 bg-slate-50/60 p-1.5">
            <button type="button" :class="btn(false)" title="ย้อนกลับ" @click="editor.chain().focus().undo().run()"><i class="bi bi-arrow-counterclockwise"></i></button>
            <button type="button" :class="btn(false)" title="ทำซ้ำ" @click="editor.chain().focus().redo().run()"><i class="bi bi-arrow-clockwise"></i></button>
            <span class="mx-1 h-5 w-px bg-slate-200"></span>

            <button type="button" :class="btn(editor.isActive('heading', { level: 2 }))" title="หัวข้อใหญ่" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()">H2</button>
            <button type="button" :class="btn(editor.isActive('heading', { level: 3 }))" title="หัวข้อรอง" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()">H3</button>
            <span class="mx-1 h-5 w-px bg-slate-200"></span>

            <button type="button" :class="btn(editor.isActive('bold'))" title="ตัวหนา" @click="editor.chain().focus().toggleBold().run()"><i class="bi bi-type-bold"></i></button>
            <button type="button" :class="btn(editor.isActive('italic'))" title="ตัวเอียง" @click="editor.chain().focus().toggleItalic().run()"><i class="bi bi-type-italic"></i></button>
            <button type="button" :class="btn(editor.isActive('underline'))" title="ขีดเส้นใต้" @click="editor.chain().focus().toggleUnderline().run()"><i class="bi bi-type-underline"></i></button>
            <button type="button" :class="btn(editor.isActive('strike'))" title="ขีดฆ่า" @click="editor.chain().focus().toggleStrike().run()"><i class="bi bi-type-strikethrough"></i></button>
            <span class="mx-1 h-5 w-px bg-slate-200"></span>

            <button type="button" :class="btn(editor.isActive('bulletList'))" title="รายการหัวข้อ" @click="editor.chain().focus().toggleBulletList().run()"><i class="bi bi-list-ul"></i></button>
            <button type="button" :class="btn(editor.isActive('orderedList'))" title="รายการลำดับ" @click="editor.chain().focus().toggleOrderedList().run()"><i class="bi bi-list-ol"></i></button>
            <button type="button" :class="btn(editor.isActive('blockquote'))" title="คำพูด / อ้างอิง" @click="editor.chain().focus().toggleBlockquote().run()"><i class="bi bi-quote"></i> อ้างอิง</button>
            <button type="button" :class="btn(false)" title="เส้นคั่น" @click="editor.chain().focus().setHorizontalRule().run()"><i class="bi bi-dash-lg"></i></button>
            <span class="mx-1 h-5 w-px bg-slate-200"></span>

            <button type="button" :class="btn(editor.isActive({ textAlign: 'left' }))" title="ชิดซ้าย" @click="editor.chain().focus().setTextAlign('left').run()"><i class="bi bi-text-left"></i></button>
            <button type="button" :class="btn(editor.isActive({ textAlign: 'center' }))" title="กึ่งกลาง" @click="editor.chain().focus().setTextAlign('center').run()"><i class="bi bi-text-center"></i></button>
            <button type="button" :class="btn(editor.isActive({ textAlign: 'right' }))" title="ชิดขวา" @click="editor.chain().focus().setTextAlign('right').run()"><i class="bi bi-text-right"></i></button>
            <span class="mx-1 h-5 w-px bg-slate-200"></span>

            <button type="button" :class="btn(editor.isActive('link'))" title="แทรกลิงก์" @click="setLink"><i class="bi bi-link-45deg"></i></button>
            <button type="button" :class="btn(false)" title="แทรกรูปภาพ" @click="addImage"><i class="bi bi-image"></i></button>
            <button type="button" :class="btn(false)" title="ล้างรูปแบบ" @click="editor.chain().focus().unsetAllMarks().clearNodes().run()"><i class="bi bi-eraser"></i></button>
        </div>
        <EditorContent :editor="editor" />
    </div>
</template>
