<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    // useForm object
    form: { type: Object, required: true },
    // รายชื่อฟิลด์ข้อความที่จะเก็บเป็นร่าง (ห้ามใส่ฟิลด์ไฟล์)
    fields: { type: Array, required: true },
    // คีย์เฉพาะของฟอร์มนี้ เช่น 'news-new' หรือ 'news-12'
    storageKey: { type: String, required: true },
    enabled: { type: Boolean, default: true },
});

const KEY = 'pjs-draft:' + props.storageKey;
const hasDraft = ref(false);
const draftAt = ref('');
let saved = null;
let mounted = false;
let timer = null;

function readDraft() {
    try {
        const raw = localStorage.getItem(KEY);
        return raw ? JSON.parse(raw) : null;
    } catch (e) {
        return null;
    }
}

function hasContent(data) {
    return props.fields.some((f) => {
        const v = data[f];
        if (v === null || v === undefined || v === '') return false;
        if (Array.isArray(v)) return v.length > 0;
        if (typeof v === 'object') return Object.keys(v).length > 0;
        return true;
    });
}

function snapshot() {
    const data = {};
    props.fields.forEach((f) => {
        try {
            data[f] = JSON.parse(JSON.stringify(props.form[f] ?? null));
        } catch (e) {
            data[f] = null;
        }
    });
    return data;
}

onMounted(() => {
    if (props.enabled) {
        const d = readDraft();
        if (d && d.data && hasContent(d.data)) {
            saved = d.data;
            draftAt.value = d.at || '';
            hasDraft.value = true;
        }
    }
    mounted = true;
});

// autosave (debounce)
watch(
    () => props.fields.map((f) => props.form[f]),
    () => {
        if (!mounted || !props.enabled) return;
        clearTimeout(timer);
        timer = setTimeout(() => {
            const data = snapshot();
            if (hasContent(data)) {
                try {
                    localStorage.setItem(KEY, JSON.stringify({ at: new Date().toLocaleString('th-TH'), data }));
                } catch (e) {}
            }
        }, 700);
    },
    { deep: true },
);

// เคลียร์ร่างเมื่อบันทึกสำเร็จ
watch(
    () => props.form.recentlySuccessful,
    (v) => {
        if (v) {
            try {
                localStorage.removeItem(KEY);
            } catch (e) {}
            hasDraft.value = false;
        }
    },
);

function restore() {
    if (saved) {
        props.fields.forEach((f) => {
            if (f in saved) props.form[f] = saved[f];
        });
    }
    hasDraft.value = false;
}

function discard() {
    try {
        localStorage.removeItem(KEY);
    } catch (e) {}
    hasDraft.value = false;
}
</script>

<template>
    <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="-translate-y-2 opacity-0"
    >
        <div
            v-if="hasDraft"
            class="flex flex-wrap items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800"
        >
            <i class="bi bi-file-earmark-text text-base text-amber-500"></i>
            <span>
                พบ<strong>ฉบับร่าง</strong>ที่ยังไม่ได้บันทึก<span v-if="draftAt" class="text-amber-600"> (บันทึกร่างเมื่อ {{ draftAt }})</span>
            </span>
            <div class="ml-auto flex items-center gap-2">
                <button type="button" class="btn-outline btn-sm" @click="discard"><i class="bi bi-trash"></i> ละทิ้งร่าง</button>
                <button type="button" class="btn-primary btn-sm" @click="restore"><i class="bi bi-arrow-counterclockwise"></i> กู้คืนฉบับร่าง</button>
            </div>
        </div>
    </Transition>
</template>
