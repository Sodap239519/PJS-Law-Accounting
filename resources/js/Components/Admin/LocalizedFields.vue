<script setup>
import { ref, reactive, watch } from 'vue';

const props = defineProps({
    // useForm object — ฟิลด์ไทยผูกกับ form โดยตรง
    form: { type: Object, required: true },
    // [{ key, label, type: 'text'|'textarea', rows, required, placeholder }]
    fields: { type: Array, required: true },
    // { en: {key: val}, zh: {...} } หรือ null
    translations: { type: [Object, null], default: null },
});
const emit = defineEmits(['update:translations']);

const TABS = [
    { code: 'th', label: 'ไทย' },
    { code: 'en', label: 'English' },
    { code: 'zh', label: '中文' },
];
const active = ref('th');

const tr = reactive({ en: {}, zh: {} });
props.fields.forEach((f) => {
    tr.en[f.key] = props.translations?.en?.[f.key] || '';
    tr.zh[f.key] = props.translations?.zh?.[f.key] || '';
});

watch(
    tr,
    () => {
        const out = {};
        for (const code of ['en', 'zh']) {
            const filled = {};
            let has = false;
            props.fields.forEach((f) => {
                const v = tr[code][f.key];
                if (v && String(v).trim()) {
                    filled[f.key] = v;
                    has = true;
                }
            });
            if (has) out[code] = filled;
        }
        emit('update:translations', Object.keys(out).length ? out : null);
    },
    { deep: true },
);

const filledTab = (code) => (code === 'th' ? false : props.fields.some((f) => String(tr[code]?.[f.key] || '').trim()));
</script>

<template>
    <div>
        <!-- Language tabs -->
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
                <span v-if="filledTab(t.code)" class="absolute -right-0.5 -top-0.5 h-2 w-2 rounded-full bg-green-500"></span>
            </button>
        </div>

        <!-- Thai (main) -->
        <div v-show="active === 'th'" class="space-y-3">
            <div v-for="f in fields" :key="'th-' + f.key">
                <label class="field-label">{{ f.label }}<span v-if="f.required" class="text-red-500"> *</span></label>
                <textarea v-if="f.type === 'textarea'" v-model="form[f.key]" :rows="f.rows || 3" class="field" :placeholder="f.placeholder || ''"></textarea>
                <input v-else v-model="form[f.key]" type="text" class="field" :placeholder="f.placeholder || ''" />
                <p v-if="form.errors && form.errors[f.key]" class="mt-1 text-sm text-red-500">{{ form.errors[f.key] }}</p>
            </div>
        </div>

        <!-- Translations en / zh -->
        <template v-for="code in ['en', 'zh']" :key="code">
            <div v-show="active === code" class="space-y-3">
                <p class="rounded-lg bg-slate-50 px-3 py-2 text-xs text-slate-500">
                    <i class="bi bi-translate"></i> คำแปล{{ code === 'en' ? 'ภาษาอังกฤษ' : 'ภาษาจีน' }} (เว้นว่างได้ — ระบบจะใช้ภาษาไทยแทน)
                </p>
                <div v-for="f in fields" :key="code + '-' + f.key">
                    <label class="field-label">{{ f.label }}</label>
                    <textarea v-if="f.type === 'textarea'" v-model="tr[code][f.key]" :rows="f.rows || 3" class="field" :placeholder="f.placeholder || ''"></textarea>
                    <input v-else v-model="tr[code][f.key]" type="text" class="field" :placeholder="f.placeholder || ''" />
                </div>
            </div>
        </template>
    </div>
</template>
