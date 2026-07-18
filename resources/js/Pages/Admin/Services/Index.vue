<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useDragReorder } from '@/composables/useDragReorder';

const props = defineProps({
    services: { type: Array, default: () => [] },
});

const { items, dragIndex, overIndex, saving, onDragStart, onDragOver, onDrop, onDragEnd } = useDragReorder(
    props.services,
    'admin.services.reorder',
);

const destroy = (id) => {
    if (confirm('ยืนยันการลบบริการนี้?')) router.delete(route('admin.services.destroy', id));
};
</script>

<template>
    <Head title="บริการ" />
    <AdminLayout>
        <template #title>บริการ</template>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <p class="flex items-center gap-1.5 text-xs text-slate-400">
                <i class="bi bi-arrows-move"></i> ลากไอคอน <i class="bi bi-grip-vertical"></i> เพื่อจัดลำดับการแสดงผล
            </p>
            <span v-if="saving" class="flex items-center gap-1 text-xs text-pjs-blue">
                <i class="bi bi-arrow-repeat animate-spin"></i> กำลังบันทึกลำดับ…
            </span>
            <Link :href="route('admin.services.create')" class="btn-primary ml-auto">+ เพิ่มบริการ</Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <table class="min-w-full divide-y text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="w-10 px-2 py-3"></th>
                        <th class="w-14 px-4 py-3 text-center">ลำดับ</th>
                        <th class="px-4 py-3">ไอคอน</th>
                        <th class="px-4 py-3">ชื่อบริการ</th>
                        <th class="px-4 py-3">สถานะ</th>
                        <th class="px-4 py-3 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr
                        v-for="(item, i) in items"
                        :key="item.id"
                        draggable="true"
                        class="transition-colors"
                        :class="[
                            dragIndex === i ? 'opacity-40' : 'hover:bg-slate-50',
                            overIndex === i && dragIndex !== i ? 'bg-pjs-blue/5 ring-1 ring-inset ring-pjs-blue/30' : '',
                        ]"
                        @dragstart="onDragStart(i)"
                        @dragover="onDragOver(i, $event)"
                        @drop="onDrop(i)"
                        @dragend="onDragEnd"
                    >
                        <td class="px-2 py-2 text-center">
                            <i class="bi bi-grip-vertical cursor-grab text-slate-300 hover:text-slate-500 active:cursor-grabbing"></i>
                        </td>
                        <td class="px-4 py-2 text-center font-medium text-slate-400">{{ i + 1 }}</td>
                        <td class="px-4 py-2">
                            <img v-if="item.cover" :src="item.cover" class="h-9 w-9 rounded object-cover" />
                            <i v-else-if="item.icon" :class="item.icon" class="text-xl text-pjs-blue"></i>
                            <span v-else class="text-slate-300">—</span>
                        </td>
                        <td class="px-4 py-2 font-medium text-slate-800">{{ item.title }}</td>
                        <td class="px-4 py-2">
                            <span :class="item.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="rounded-full px-2 py-0.5 text-xs">
                                {{ item.is_active ? 'ใช้งาน' : 'ปิด' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <Link :href="route('admin.services.edit', item.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                            <button class="ml-3 text-red-500 hover:underline" @click="destroy(item.id)">ลบ</button>
                        </td>
                    </tr>
                    <tr v-if="!items.length">
                        <td colspan="6" class="px-4 py-10 text-center text-slate-400">ยังไม่มีบริการ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
