<script setup>
import { ref, reactive, computed, watch } from 'vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';

const props = defineProps({
    title: { type: String, default: '' },
    content: { type: String, default: '' },
    // { en: {title, content}, zh: {...} } หรือ null
    translations: { type: [Object, null], default: null },
    titleLabel: { type: String, default: 'หัวข้อ' },
    contentLabel: { type: String, default: 'เนื้อหา' },
    titleError: { type: String, default: '' },
    contentError: { type: String, default: '' },
    contentHeight: { type: Number, default: 380 },
});
const emit = defineEmits(['update:title', 'update:content', 'update:translations']);

const TABS = [
    { code: 'th', label: 'ไทย' },
    { code: 'en', label: 'English' },
    { code: 'zh', label: '中文' },
];
const active = ref('th');

// ฟิลด์ไทย (ผูกกับ v-model หลักของฟอร์ม)
const titleProxy = computed({ get: () => props.title, set: (v) => emit('update:title', v) });
const contentProxy = computed({ get: () => props.content, set: (v) => emit('update:content', v) });

// คำแปล en/zh
const tr = reactive({
    en: { title: props.translations?.en?.title || '', content: props.translations?.en?.content || '' },
    zh: { title: props.translations?.zh?.title || '', content: props.translations?.zh?.content || '' },
});

watch(
    tr,
    () => {
        const out = {};
        for (const code of ['en', 'zh']) {
            if ((tr[code].title || '').trim() || (tr[code].content || '').trim()) out[code] = { ...tr[code] };
        }
        emit('update:translations', Object.keys(out).length ? out : null);
    },
    { deep: true },
);

// จุดสังเกตว่ามีคำแปลกรอกไว้ไหม (โชว์จุดบนแท็บ)
const filled = (code) => !!((tr[code]?.title || '').trim() || (tr[code]?.content || '').trim());
</script>

<template>
    <div>
        <!-- Language tabs (วงรี) -->
        <div class="mb-4 inline-flex gap-1 rounded-full bg-slate-100 p-1">
            <button
                v-for="t in TABS"
                :key="t.code"
                type="button"
                class="relative rounded-full px-4 py-1.5 text-sm font-medium transition"
                :class="active === t.code ? 'bg-white text-pjs-blue shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                @click="active = t.code"
            >
                {{ t.label }}
                <span v-if="t.code !== 'th' && filled(t.code)" class="absolute -right-0.5 -top-0.5 h-2 w-2 rounded-full bg-green-500"></span>
            </button>
        </div>

        <!-- Thai (main) -->
        <div v-show="active === 'th'">
            <label class="mb-1 block text-sm font-medium text-slate-600">{{ titleLabel }} *</label>
            <input v-model="titleProxy" type="text" class="field" />
            <p v-if="titleError" class="mt-1 text-sm text-red-500">{{ titleError }}</p>

            <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">{{ contentLabel }} *</label>
            <RichEditor v-model="contentProxy" :height="contentHeight" />
            <p v-if="contentError" class="mt-1 text-sm text-red-500">{{ contentError }}</p>
        </div>

        <!-- Translations -->
        <template v-for="code in ['en', 'zh']" :key="code">
            <div v-if="active === code">
                <p class="mb-3 flex items-center gap-1.5 rounded-lg bg-pjs-blue/5 px-3 py-2 text-xs text-pjs-blue-dark">
                    <i class="bi bi-translate"></i> ถ้าไม่กรอกคำแปล หน้าเว็บจะใช้ Google แปลจากภาษาไทยอัตโนมัติ — กรอกเองเพื่อความแม่นยำ
                </p>
                <label class="mb-1 block text-sm font-medium text-slate-600">{{ titleLabel }}</label>
                <input v-model="tr[code].title" type="text" class="field" />

                <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">{{ contentLabel }}</label>
                <RichEditor v-model="tr[code].content" :height="contentHeight" />
            </div>
        </template>
    </div>
</template>
