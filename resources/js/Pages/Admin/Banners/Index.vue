<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useDragReorder } from '@/composables/useDragReorder';

const props = defineProps({
    banners: { type: Array, default: () => [] },
});

const { items, dragIndex, overIndex, saving, onDragStart, onDragOver, onDrop, onDragEnd } = useDragReorder(
    props.banners,
    'admin.banners.reorder',
);

const destroy = (id) => {
    if (confirm('ยืนยันการลบแบนเนอร์นี้?')) router.delete(route('admin.banners.destroy', id));
};
</script>

<template>
    <Head title="แบนเนอร์" />
    <AdminLayout>
        <template #title>แบนเนอร์หน้าแรก</template>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <p class="flex items-center gap-1.5 text-xs text-slate-400">
                <i class="bi bi-grip-vertical"></i> ลากเพื่อจัดลำดับการแสดงบนหน้าแรก
            </p>
            <span v-if="saving" class="flex items-center gap-1 text-xs text-pjs-blue">
                <i class="bi bi-arrow-repeat animate-spin"></i> กำลังบันทึกลำดับ…
            </span>
            <Link :href="route('admin.banners.create')" class="btn-primary ml-auto">+ เพิ่มแบนเนอร์</Link>
        </div>

        <div v-if="items.length" class="grid gap-3">
            <div
                v-for="(item, i) in items"
                :key="item.id"
                draggable="true"
                class="flex items-center gap-4 rounded-2xl border bg-white p-3 shadow-sm transition-colors"
                :class="[
                    dragIndex === i ? 'opacity-40' : 'hover:border-pjs-blue/30',
                    overIndex === i && dragIndex !== i ? 'ring-1 ring-inset ring-pjs-blue/40' : 'border-slate-100',
                ]"
                @dragstart="onDragStart(i)"
                @dragover="onDragOver(i, $event)"
                @drop="onDrop(i)"
                @dragend="onDragEnd"
            >
                <i class="bi bi-grip-vertical cursor-grab text-slate-300 hover:text-slate-500 active:cursor-grabbing"></i>
                <div class="aspect-video w-40 shrink-0 overflow-hidden rounded-lg bg-slate-100">
                    <img v-if="item.image" :src="item.image" class="h-full w-full object-cover" />
                    <div v-else class="flex h-full items-center justify-center text-slate-300"><i class="bi bi-image text-2xl"></i></div>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-medium text-slate-800">{{ item.title || '(ไม่มีหัวข้อ)' }}</p>
                    <p class="truncate text-sm text-slate-400">{{ item.subtitle || '—' }}</p>
                    <p v-if="item.link_url" class="mt-0.5 truncate text-xs text-pjs-blue"><i class="bi bi-link-45deg"></i> {{ item.link_url }}</p>
                </div>
                <span :class="item.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="shrink-0 rounded-full px-2 py-0.5 text-xs">
                    {{ item.is_active ? 'แสดง' : 'ซ่อน' }}
                </span>
                <div class="flex shrink-0 gap-3 text-sm">
                    <Link :href="route('admin.banners.edit', item.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                    <button class="text-red-500 hover:underline" @click="destroy(item.id)">ลบ</button>
                </div>
            </div>
        </div>
        <div v-else class="rounded-2xl border border-slate-100 bg-white py-16 text-center text-slate-400 shadow-sm">
            ยังไม่มีแบนเนอร์
        </div>
    </AdminLayout>
</template>
