<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
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

// สถานะโหลดตัวแก้ไข (TinyMCE โหลดจาก CDN — ใช้เวลาสักครู่)
const ready = ref(false);
const loadPct = ref(0);
let trickle = null;

onMounted(() => {
    trickle = setInterval(() => {
        if (loadPct.value < 92) {
            loadPct.value = Math.min(92, loadPct.value + Math.max(1, (92 - loadPct.value) * 0.08));
        }
    }, 120);
});
onUnmounted(() => clearInterval(trickle));

const onReady = () => {
    loadPct.value = 100;
    clearInterval(trickle);
    setTimeout(() => (ready.value = true), 150);
};

// โหลด TinyMCE 6 จาก CDN (ฟรี GPL — ไม่ต้องใช้ API key/license)
const scriptSrc = 'https://cdn.jsdelivr.net/npm/tinymce@6.8.6/tinymce.min.js';

// อัปโหลดรูปไปเซิร์ฟเวอร์ แล้วคืน URL (ส่ง CSRF จาก cookie XSRF-TOKEN แบบเดียวกับ axios)
const uploadImage = (file) => {
    const fd = new FormData();
    fd.append('file', file);
    const xsrf = decodeURIComponent((document.cookie.match(/XSRF-TOKEN=([^;]+)/) || [])[1] || '');
    return fetch('/admin/editor/image', {
        method: 'POST',
        headers: { 'X-XSRF-TOKEN': xsrf, Accept: 'application/json' },
        body: fd,
    }).then(async (r) => {
        if (!r.ok) throw new Error('อัปโหลดรูปไม่สำเร็จ');
        return (await r.json()).location;
    });
};

const init = {
    height: props.height,
    menubar: 'edit insert view format table tools',
    // อัปโหลดรูป: เลือกไฟล์ในกล่อง Insert Image, ลาก-วาง, และวาง (paste)
    automatic_uploads: true,
    file_picker_types: 'image',
    images_upload_handler: (blobInfo) => uploadImage(blobInfo.blob()),
    file_picker_callback: (cb) => {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = () => {
            const file = input.files[0];
            if (file) uploadImage(file).then((url) => cb(url, { title: file.name }));
        };
        input.click();
    },
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount emoticons',
    toolbar:
        'undo redo | blocks fontsize | bold italic underline forecolor backcolor | ' +
        'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ' +
        'link image media table | blockquote code | removeformat | fullscreen',
    // ขนาดฟอนต์ให้เลือก (หน้าเว็บจะแสดงตามที่เลือกจริง)
    fontsize_formats: '12px 14px 16px 18px 20px 24px 28px 32px 36px 42px 48px',
    toolbar_mode: 'scrolling', // แถบเครื่องมือแถวเดียว เลื่อนแนวนอนได้ (ดีบนมือถือ)
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
    <div class="tinymce-wrap relative overflow-hidden rounded-xl border border-slate-200">
        <Editor v-model="value" :tinymce-script-src="scriptSrc" :init="init" @init="onReady" />

        <!-- Loading overlay + percentage -->
        <Transition leave-active-class="transition-opacity duration-300" leave-to-class="opacity-0">
            <div v-if="!ready" class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 bg-white" :style="{ minHeight: height + 'px' }">
                <div class="relative h-14 w-14">
                    <svg class="h-14 w-14 -rotate-90" viewBox="0 0 50 50">
                        <circle cx="25" cy="25" r="20" fill="none" stroke="#dbeafe" stroke-width="5" />
                        <circle cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="5" stroke-linecap="round" :stroke-dasharray="125.6" :stroke-dashoffset="125.6 - (125.6 * loadPct) / 100" style="transition: stroke-dashoffset 0.15s ease" />
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-xs font-semibold text-pjs-blue-dark">{{ Math.round(loadPct) }}%</span>
                </div>
                <p class="text-xs font-medium text-slate-500">กำลังโหลดตัวแก้ไขข้อความ…</p>
            </div>
        </Transition>
    </div>
</template>

<style>
/* ทำให้ขอบ TinyMCE เข้ากับดีไซน์ */
.tinymce-wrap .tox-tinymce {
    border: 0 !important;
    border-radius: 0 !important;
}

/* จอมือถือ: ซ่อนเมนูบาร์ (ประหยัดพื้นที่) — แถบเครื่องมือเลื่อนแนวนอนได้เอง */
@media (max-width: 640px) {
    .tinymce-wrap .tox-menubar {
        display: none !important;
    }
}
</style>
