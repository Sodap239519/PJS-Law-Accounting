<script setup>
import { ref } from 'vue';

const props = defineProps({
    existing: { type: Array, default: () => [] }, // [{ id, url, name }]
    label: { type: String, default: 'รูปประกอบ (หลายรูป)' },
});
const emit = defineEmits(['update:files', 'update:deleted']);

const existingItems = ref([...props.existing]);
const newItems = ref([]); // [{ file, url }]
const deleted = ref([]);
const inputRef = ref(null);

const onSelect = (e) => {
    for (const file of e.target.files) {
        newItems.value.push({ file, url: URL.createObjectURL(file) });
    }
    e.target.value = '';
    emit('update:files', newItems.value.map((i) => i.file));
};

const removeNew = (idx) => {
    newItems.value.splice(idx, 1);
    emit('update:files', newItems.value.map((i) => i.file));
};

const removeExisting = (id) => {
    existingItems.value = existingItems.value.filter((i) => i.id !== id);
    deleted.value.push(id);
    emit('update:deleted', deleted.value);
};
</script>

<template>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-600">{{ label }}</label>
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
            <div v-for="img in existingItems" :key="'e' + img.id" class="group relative aspect-square overflow-hidden rounded-lg border">
                <img :src="img.url" class="h-full w-full object-cover" />
                <button type="button" class="absolute right-1 top-1 rounded-full bg-red-600 px-1.5 text-xs text-white opacity-90" @click="removeExisting(img.id)">✕</button>
            </div>
            <div v-for="(img, idx) in newItems" :key="'n' + idx" class="group relative aspect-square overflow-hidden rounded-lg border border-pjs-blue">
                <img :src="img.url" class="h-full w-full object-cover" />
                <button type="button" class="absolute right-1 top-1 rounded-full bg-red-600 px-1.5 text-xs text-white opacity-90" @click="removeNew(idx)">✕</button>
            </div>
            <button type="button" class="flex aspect-square items-center justify-center rounded-lg border-2 border-dashed border-slate-200 text-2xl text-slate-400 hover:border-pjs-blue hover:text-pjs-blue" @click="inputRef.click()">
                +
            </button>
        </div>
        <input ref="inputRef" type="file" accept="image/*" multiple class="hidden" @change="onSelect" />
    </div>
</template>
