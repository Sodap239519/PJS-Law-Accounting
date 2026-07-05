<script setup>
import { ref } from 'vue';

const props = defineProps({
    existing: { type: Array, default: () => [] }, // [{ id, url, name }]
    label: { type: String, default: 'รูปประกอบ (หลายรูป)' },
});
const emit = defineEmits(['update:files', 'update:deleted', 'update:order']);

// รวมรูปเดิม + รูปใหม่ ไว้ในลิสต์เดียว ลากสลับได้
let uid = 0;
const items = ref(
    props.existing.map((e) => ({ key: 'e' + e.id, id: e.id, url: e.url, isNew: false })),
);
const deleted = ref([]);
const inputRef = ref(null);

// drag state
const dragIndex = ref(null);
const overIndex = ref(null);

// lightbox
const lightbox = ref(null);

const emitAll = () => {
    emit('update:files', items.value.filter((i) => i.isNew).map((i) => i.file));

    let n = 0;
    emit(
        'update:order',
        items.value.map((i) => (i.isNew ? { new: n++ } : { id: i.id })),
    );
};

const onSelect = (e) => {
    for (const file of e.target.files) {
        items.value.push({ key: 'n' + uid++, file, url: URL.createObjectURL(file), isNew: true });
    }
    e.target.value = '';
    emitAll();
};

const removeItem = (idx) => {
    const [removed] = items.value.splice(idx, 1);
    if (removed && !removed.isNew) {
        deleted.value.push(removed.id);
        emit('update:deleted', deleted.value);
    }
    emitAll();
};

const onDragStart = (i) => (dragIndex.value = i);
const onDragOver = (i, e) => {
    e.preventDefault();
    overIndex.value = i;
};
const onDrop = (i) => {
    const from = dragIndex.value;
    dragIndex.value = null;
    overIndex.value = null;
    if (from === null || from === i) return;
    const list = items.value;
    const [moved] = list.splice(from, 1);
    list.splice(i, 0, moved);
    emitAll();
};
const onDragEnd = () => {
    dragIndex.value = null;
    overIndex.value = null;
};

const openLightbox = (url) => (lightbox.value = url);
const closeLightbox = () => (lightbox.value = null);
</script>

<template>
    <div>
        <label v-if="label" class="mb-1 block text-sm font-medium text-slate-600">{{ label }}</label>
        <p v-if="items.length > 1" class="mb-2 flex items-center gap-1.5 text-xs text-slate-400">
            <i class="bi bi-arrows-move"></i> ลากเพื่อจัดลำดับ · คลิกรูปเพื่อดูภาพเต็ม
        </p>

        <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
            <div
                v-for="(img, idx) in items"
                :key="img.key"
                draggable="true"
                class="group relative aspect-square overflow-hidden rounded-lg border transition"
                :class="[
                    img.isNew ? 'border-pjs-blue' : 'border-slate-200',
                    dragIndex === idx ? 'opacity-40' : '',
                    overIndex === idx && dragIndex !== idx ? 'ring-2 ring-pjs-blue/50' : '',
                ]"
                @dragstart="onDragStart(idx)"
                @dragover="onDragOver(idx, $event)"
                @drop="onDrop(idx)"
                @dragend="onDragEnd"
            >
                <img :src="img.url" class="h-full w-full cursor-zoom-in object-cover" @click="openLightbox(img.url)" />
                <!-- order badge -->
                <span class="absolute left-1 top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-black/55 px-1 text-[10px] font-semibold text-white">{{ idx + 1 }}</span>
                <!-- delete -->
                <button type="button" class="absolute right-1 top-1 rounded-full bg-red-600 px-1.5 text-xs text-white opacity-90 hover:bg-red-700" @click.stop="removeItem(idx)">✕</button>
                <!-- drag hint -->
                <span class="pointer-events-none absolute inset-x-0 bottom-0 flex justify-center bg-gradient-to-t from-black/40 to-transparent py-0.5 text-white opacity-0 transition group-hover:opacity-100">
                    <i class="bi bi-grip-horizontal text-xs"></i>
                </span>
            </div>

            <button type="button" class="flex aspect-square items-center justify-center rounded-lg border-2 border-dashed border-slate-200 text-2xl text-slate-400 hover:border-pjs-blue hover:text-pjs-blue" @click="inputRef.click()">
                +
            </button>
        </div>
        <input ref="inputRef" type="file" accept="image/*" multiple class="hidden" @change="onSelect" />

        <!-- Lightbox -->
        <Teleport to="body">
            <div v-if="lightbox" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-4" @click="closeLightbox">
                <img :src="lightbox" class="max-h-[90vh] max-w-[90vw] rounded-lg object-contain shadow-2xl" @click.stop />
                <button type="button" class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/15 text-xl text-white hover:bg-white/25" @click="closeLightbox">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </Teleport>
    </div>
</template>
