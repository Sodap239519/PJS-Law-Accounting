<script setup>
import { ref, watch } from 'vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';

const props = defineProps({
    // { en: {title, excerpt, content}, zh: {...} } หรือ null
    modelValue: { type: [Object, null], default: null },
    // [{ key, label, type: 'text'|'textarea'|'rich' }]
    fields: { type: Array, default: () => [] },
});
const emit = defineEmits(['update:modelValue']);

const LANGS = [
    { code: 'en', label: 'อังกฤษ (English)' },
    { code: 'zh', label: 'จีน (中文)' },
];

const state = ref({
    en: { enabled: !!props.modelValue?.en, data: { ...(props.modelValue?.en || {}) } },
    zh: { enabled: !!props.modelValue?.zh, data: { ...(props.modelValue?.zh || {}) } },
});

watch(
    state,
    () => {
        const out = {};
        for (const code of ['en', 'zh']) {
            if (state.value[code].enabled) out[code] = state.value[code].data;
        }
        emit('update:modelValue', Object.keys(out).length ? out : null);
    },
    { deep: true },
);
</script>

<template>
    <div>
        <div class="mb-3 flex items-center gap-2">
            <i class="bi bi-translate text-pjs-blue"></i>
            <label class="text-sm font-semibold text-slate-700">ภาษาเพิ่มเติม</label>
        </div>
        <p class="mb-3 text-xs text-slate-400">
            เนื้อหาหลักเป็นภาษาไทย — ถ้าไม่เพิ่มคำแปล หน้าเว็บจะใช้ Google แปลให้อัตโนมัติ ติ๊กด้านล่างเพื่อกรอกคำแปลเอง (แม่นยำกว่า)
        </p>

        <div class="flex flex-wrap gap-4">
            <label v-for="lang in LANGS" :key="lang.code" class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                <input v-model="state[lang.code].enabled" type="checkbox" class="rounded border-slate-300 text-pjs-blue focus:ring-pjs-blue" />
                เพิ่มภาษา{{ lang.label }}
            </label>
        </div>

        <template v-for="lang in LANGS" :key="'panel-' + lang.code">
            <div v-if="state[lang.code].enabled" class="mt-4 rounded-xl border border-pjs-blue/20 bg-pjs-blue/5 p-4">
                <p class="mb-3 text-sm font-semibold text-pjs-blue-dark">
                    <i class="bi bi-globe"></i> คำแปล — {{ lang.label }}
                </p>
                <div class="space-y-3">
                    <div v-for="f in fields" :key="f.key">
                        <label class="mb-1 block text-xs font-medium text-slate-500">{{ f.label }}</label>
                        <input
                            v-if="f.type === 'text'"
                            v-model="state[lang.code].data[f.key]"
                            type="text"
                            class="w-full rounded-lg border-slate-300 text-sm"
                        />
                        <textarea
                            v-else-if="f.type === 'textarea'"
                            v-model="state[lang.code].data[f.key]"
                            rows="2"
                            class="w-full rounded-lg border-slate-300 text-sm"
                        ></textarea>
                        <RichEditor v-else-if="f.type === 'rich'" v-model="state[lang.code].data[f.key]" />
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>
