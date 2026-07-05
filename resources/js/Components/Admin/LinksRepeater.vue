<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: { type: Array, default: () => [] }, // [{ label, url }]
    label: { type: String, default: 'ลิงก์แนบ' },
});
const emit = defineEmits(['update:modelValue']);

const rows = ref(props.modelValue.length ? [...props.modelValue] : []);

watch(rows, (val) => emit('update:modelValue', val), { deep: true });

const addRow = () => rows.value.push({ label: '', url: '' });
const removeRow = (idx) => rows.value.splice(idx, 1);
</script>

<template>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-600">{{ label }}</label>
        <div class="space-y-2">
            <div v-for="(row, idx) in rows" :key="idx" class="flex flex-col gap-2 sm:flex-row">
                <input
                    v-model="row.label"
                    type="text"
                    placeholder="ข้อความลิงก์ (เช่น เว็บไซต์ที่เกี่ยวข้อง)"
                    class="w-full rounded-lg border-slate-200 text-sm sm:w-1/3"
                />
                <input
                    v-model="row.url"
                    type="url"
                    placeholder="https://..."
                    class="w-full rounded-lg border-slate-200 text-sm"
                />
                <button type="button" class="rounded-lg border border-red-200 px-3 text-red-500 hover:bg-red-50" @click="removeRow(idx)">✕</button>
            </div>
        </div>
        <button type="button" class="mt-2 rounded-lg border border-dashed border-slate-200 px-4 py-2 text-sm text-slate-600 hover:border-pjs-blue hover:text-pjs-blue" @click="addRow">
            + เพิ่มลิงก์
        </button>
    </div>
</template>
