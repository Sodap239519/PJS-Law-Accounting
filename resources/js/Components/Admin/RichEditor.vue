<script setup>
import { computed } from 'vue';
import Editor from '@tinymce/tinymce-vue';

const props = defineProps({
    modelValue: { type: String, default: '' },
    height: { type: Number, default: 380 },
});
const emit = defineEmits(['update:modelValue']);

const value = computed({
    get: () => props.modelValue,
    set: (v) => emit('update:modelValue', v),
});

// โหลด TinyMCE 6 จาก CDN (ฟรี GPL — ไม่ต้องใช้ API key/license)
const scriptSrc = 'https://cdn.jsdelivr.net/npm/tinymce@6.8.6/tinymce.min.js';

const init = {
    height: props.height,
    menubar: 'edit insert view format table tools',
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount emoticons',
    toolbar:
        'undo redo | blocks | bold italic underline forecolor backcolor | ' +
        'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ' +
        'link image media table | blockquote code | removeformat | fullscreen',
    toolbar_mode: 'sliding',
    branding: false,
    promotion: false,
    statusbar: true,
    content_style:
        "@import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');" +
        "body{font-family:'Prompt',sans-serif;font-size:15px;line-height:1.7;color:#334155;padding:8px 12px;}" +
        'h1,h2,h3{color:#1e293b;font-weight:700;}' +
        'a{color:#2563eb;}' +
        'blockquote{border-left:3px solid #2563eb;margin:0;padding-left:14px;color:#64748b;}' +
        'img{max-width:100%;height:auto;border-radius:8px;}' +
        'table{border-collapse:collapse;}table td,table th{border:1px solid #e2e8f0;padding:6px 10px;}',
};
</script>

<template>
    <div class="tinymce-wrap overflow-hidden rounded-xl border border-slate-200">
        <Editor v-model="value" :tinymce-script-src="scriptSrc" :init="init" />
    </div>
</template>

<style>
/* ทำให้ขอบ TinyMCE เข้ากับดีไซน์ */
.tinymce-wrap .tox-tinymce {
    border: 0 !important;
    border-radius: 0 !important;
}
</style>
