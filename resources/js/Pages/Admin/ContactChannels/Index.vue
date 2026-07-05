<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useDragReorder } from '@/composables/useDragReorder';

const props = defineProps({
    channels: { type: Array, default: () => [] },
    types: { type: Object, default: () => ({}) },
});

const { items, dragIndex, overIndex, saving, onDragStart, onDragOver, onDrop, onDragEnd } = useDragReorder(
    props.channels,
    'admin.contact-channels.reorder',
);

const destroy = (id) => {
    if (confirm('ยืนยันการลบช่องทางนี้?')) router.delete(route('admin.contact-channels.destroy', id));
};
</script>

<template>
    <Head title="ช่องทางติดต่อ" />
    <AdminLayout>
        <template #title>ช่องทางติดต่อ</template>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <Link :href="route('admin.contact-channels.create')" class="rounded-lg bg-pjs-blue px-4 py-2 text-sm font-medium text-white hover:bg-pjs-blue-dark">
                + เพิ่มช่องทาง
            </Link>
            <p class="flex items-center gap-1.5 text-xs text-slate-400">
                <i class="bi bi-grip-vertical"></i> ลากเพื่อจัดลำดับ
            </p>
            <span v-if="saving" class="flex items-center gap-1 text-xs text-pjs-blue">
                <i class="bi bi-arrow-repeat animate-spin"></i> กำลังบันทึกลำดับ…
            </span>
        </div>

        <div v-if="items.length" class="grid gap-2">
            <div
                v-for="(item, i) in items"
                :key="item.id"
                draggable="true"
                class="flex items-center gap-3 rounded-xl border bg-white p-3 shadow-sm transition-colors"
                :class="[
                    dragIndex === i ? 'opacity-40' : 'hover:border-pjs-blue/30',
                    overIndex === i && dragIndex !== i ? 'ring-1 ring-inset ring-pjs-blue/40' : 'border-slate-100',
                ]"
                @dragstart="onDragStart(i)"
                @dragover="onDragOver(i, $event)"
                @drop="onDrop(i)"
                @dragend="onDragEnd"
            >
                <i class="bi bi-grip-vertical shrink-0 cursor-grab text-slate-300 hover:text-slate-500 active:cursor-grabbing"></i>
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-pjs-blue/10 text-pjs-blue">
                    <i :class="item.icon || 'bi bi-dot'" class="text-lg"></i>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-medium text-slate-800">{{ item.label || item.type_label }}</p>
                    <p class="truncate text-xs text-slate-400">{{ item.value }}</p>
                </div>
                <span class="hidden shrink-0 rounded-full bg-slate-100 px-2 py-0.5 text-[11px] text-slate-500 sm:inline">{{ item.type_label }}</span>
                <span :class="item.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="shrink-0 rounded-full px-2 py-0.5 text-xs">
                    {{ item.is_active ? 'แสดง' : 'ซ่อน' }}
                </span>
                <div class="flex shrink-0 gap-3 text-sm">
                    <Link :href="route('admin.contact-channels.edit', item.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                    <button class="text-red-500 hover:underline" @click="destroy(item.id)">ลบ</button>
                </div>
            </div>
        </div>
        <div v-else class="rounded-2xl border border-slate-100 bg-white py-16 text-center text-slate-400 shadow-sm">
            ยังไม่มีช่องทางติดต่อ
        </div>
    </AdminLayout>
</template>
