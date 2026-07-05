<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useDragReorder } from '@/composables/useDragReorder';

const props = defineProps({
    members: { type: Array, default: () => [] },
});

const { items, dragIndex, overIndex, saving, onDragStart, onDragOver, onDrop, onDragEnd } = useDragReorder(
    props.members,
    'admin.team-members.reorder',
);

const destroy = (id) => {
    if (confirm('ยืนยันการลบบุคลากรคนนี้?')) router.delete(route('admin.team-members.destroy', id));
};
</script>

<template>
    <Head title="ทีมงาน" />
    <AdminLayout>
        <template #title>ทีมงาน / บุคลากร</template>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <Link :href="route('admin.team-members.create')" class="rounded-lg bg-pjs-blue px-4 py-2 text-sm font-medium text-white hover:bg-pjs-blue-dark">
                + เพิ่มบุคลากร
            </Link>
            <p class="flex items-center gap-1.5 text-xs text-slate-400">
                <i class="bi bi-grip-vertical"></i> ลากเพื่อจัดลำดับการแสดงผล
            </p>
            <span v-if="saving" class="flex items-center gap-1 text-xs text-pjs-blue">
                <i class="bi bi-arrow-repeat animate-spin"></i> กำลังบันทึกลำดับ…
            </span>
        </div>

        <div v-if="items.length" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="(item, i) in items"
                :key="item.id"
                draggable="true"
                class="flex items-center gap-3 rounded-2xl border bg-white p-3 shadow-sm transition-colors"
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
                <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full bg-slate-100">
                    <img v-if="item.photo" :src="item.photo" class="h-full w-full object-cover" />
                    <div v-else class="flex h-full items-center justify-center text-slate-300"><i class="bi bi-person text-2xl"></i></div>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-medium text-slate-800">{{ item.name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ item.position }}</p>
                    <span v-if="!item.is_active" class="mt-1 inline-block rounded-full bg-slate-100 px-2 py-0.5 text-[10px] text-slate-500">ซ่อน</span>
                </div>
                <div class="flex shrink-0 flex-col items-end gap-1 text-sm">
                    <Link :href="route('admin.team-members.edit', item.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                    <button class="text-red-500 hover:underline" @click="destroy(item.id)">ลบ</button>
                </div>
            </div>
        </div>
        <div v-else class="rounded-2xl border border-slate-100 bg-white py-16 text-center text-slate-400 shadow-sm">
            ยังไม่มีบุคลากร
        </div>
    </AdminLayout>
</template>
