<script setup>
import { ref } from 'vue';

const props = defineProps({
    existing: { type: Array, default: () => [] }, // [{ id, url, name, size }]
    label: { type: String, default: 'ไฟล์แนบ' },
});
const emit = defineEmits(['update:files', 'update:deleted']);

const existingItems = ref([...props.existing]);
const newFiles = ref([]);
const deleted = ref([]);
const inputRef = ref(null);

const onSelect = (e) => {
    for (const file of e.target.files) newFiles.value.push(file);
    e.target.value = '';
    emit('update:files', newFiles.value);
};

const removeNew = (idx) => {
    newFiles.value.splice(idx, 1);
    emit('update:files', newFiles.value);
};

const removeExisting = (id) => {
    existingItems.value = existingItems.value.filter((i) => i.id !== id);
    deleted.value.push(id);
    emit('update:deleted', deleted.value);
};

const humanSize = (bytes) => {
    if (!bytes) return '';
    const units = ['B', 'KB', 'MB', 'GB'];
    let i = 0;
    let n = bytes;
    while (n >= 1024 && i < units.length - 1) { n /= 1024; i++; }
    return `${n.toFixed(1)} ${units[i]}`;
};
</script>

<template>
    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">{{ label }}</label>
        <ul class="mb-2 space-y-1">
            <li v-for="f in existingItems" :key="'e' + f.id" class="flex items-center gap-2 rounded-lg border bg-gray-50 px-3 py-2 text-sm">
                <span>📎</span>
                <a :href="f.url" target="_blank" class="flex-1 truncate text-pjs-blue hover:underline">{{ f.name }}</a>
                <span class="text-xs text-gray-400">{{ f.size }}</span>
                <button type="button" class="text-red-500 hover:text-red-700" @click="removeExisting(f.id)">✕</button>
            </li>
            <li v-for="(f, idx) in newFiles" :key="'n' + idx" class="flex items-center gap-2 rounded-lg border border-pjs-blue bg-blue-50 px-3 py-2 text-sm">
                <span>📎</span>
                <span class="flex-1 truncate">{{ f.name }}</span>
                <span class="text-xs text-gray-400">{{ humanSize(f.size) }}</span>
                <button type="button" class="text-red-500 hover:text-red-700" @click="removeNew(idx)">✕</button>
            </li>
        </ul>
        <button type="button" class="rounded-lg border border-dashed border-gray-300 px-4 py-2 text-sm text-gray-600 hover:border-pjs-blue hover:text-pjs-blue" @click="inputRef.click()">
            + เพิ่มไฟล์ (PDF, Word, Excel, PPT, รูป)
        </button>
        <input ref="inputRef" type="file" multiple class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,image/*" @change="onSelect" />
    </div>
</template>
