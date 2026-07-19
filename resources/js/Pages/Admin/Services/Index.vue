<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    services: { type: Array, default: () => [] },
});

// สำเนาแบบ reactive (จัดลำดับในเครื่องก่อนบันทึก)
const items = ref([...props.services]);
const saving = ref(false);
const dragId = ref(null);
const overId = ref(null);

// จัดกลุ่มตาม group โดยคงลำดับกลุ่มที่พบก่อน
const groups = computed(() => {
    const map = new Map();
    for (const s of items.value) {
        const key = s.group || 'อื่น ๆ';
        if (!map.has(key)) map.set(key, []);
        map.get(key).push(s);
    }
    return [...map.entries()].map(([label, list]) => ({ label, list }));
});

const groupOf = (item) => item.group || 'อื่น ๆ';

const onDragStart = (item) => {
    dragId.value = item.id;
};

const onDragOver = (item, e) => {
    // ลากได้เฉพาะภายในกลุ่มเดียวกัน
    const dragItem = items.value.find((s) => s.id === dragId.value);
    if (!dragItem || groupOf(dragItem) !== groupOf(item)) return;
    e.preventDefault();
    overId.value = item.id;
};

const onDrop = (target) => {
    const from = items.value.findIndex((s) => s.id === dragId.value);
    const to = items.value.findIndex((s) => s.id === target.id);
    if (from === -1 || to === -1 || from === to) return onDragEnd();
    if (groupOf(items.value[from]) !== groupOf(items.value[to])) return onDragEnd();

    const list = [...items.value];
    const [moved] = list.splice(from, 1);
    list.splice(to, 0, moved);
    items.value = list;
    onDragEnd();
    persist();
};

const onDragEnd = () => {
    dragId.value = null;
    overId.value = null;
};

const persist = () => {
    saving.value = true;
    router.post(
        route('admin.services.reorder'),
        { ids: items.value.map((s) => s.id) },
        {
            preserveScroll: true,
            preserveState: true,
            onFinish: () => (saving.value = false),
        },
    );
};

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
                <i class="bi bi-arrows-move"></i> ลากไอคอน <i class="bi bi-grip-vertical"></i> เพื่อจัดลำดับ (ภายในกลุ่มเดียวกัน)
            </p>
            <span v-if="saving" class="flex items-center gap-1 text-xs text-pjs-blue">
                <i class="bi bi-arrow-repeat animate-spin"></i> กำลังบันทึกลำดับ…
            </span>
            <Link :href="route('admin.services.create')" class="btn-primary ml-auto">+ เพิ่มบริการ</Link>
        </div>

        <div class="space-y-6">
            <div v-for="group in groups" :key="group.label" class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                <div class="flex items-center gap-2 border-b border-slate-100 bg-slate-50 px-4 py-3">
                    <i class="bi bi-collection text-pjs-blue/70"></i>
                    <h3 class="text-sm font-semibold text-slate-700">{{ group.label }}</h3>
                    <span class="rounded-full bg-slate-200/70 px-2 py-0.5 text-xs text-slate-500">{{ group.list.length }}</span>
                </div>
                <table class="min-w-full divide-y text-sm">
                    <thead class="text-left text-slate-400">
                        <tr>
                            <th class="w-10 px-2 py-2"></th>
                            <th class="px-4 py-2">ไอคอน</th>
                            <th class="px-4 py-2">ชื่อบริการ</th>
                            <th class="px-4 py-2">สถานะ</th>
                            <th class="px-4 py-2 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr
                            v-for="item in group.list"
                            :key="item.id"
                            draggable="true"
                            class="transition-colors"
                            :class="[
                                dragId === item.id ? 'opacity-40' : 'hover:bg-slate-50',
                                overId === item.id && dragId !== item.id ? 'bg-pjs-blue/5 ring-1 ring-inset ring-pjs-blue/30' : '',
                            ]"
                            @dragstart="onDragStart(item)"
                            @dragover="onDragOver(item, $event)"
                            @drop="onDrop(item)"
                            @dragend="onDragEnd"
                        >
                            <td class="px-2 py-2 text-center">
                                <i class="bi bi-grip-vertical cursor-grab text-slate-300 hover:text-slate-500 active:cursor-grabbing"></i>
                            </td>
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
                    </tbody>
                </table>
            </div>

            <div v-if="!items.length" class="rounded-2xl border border-slate-100 bg-white px-4 py-10 text-center text-slate-400 shadow-sm">
                ยังไม่มีบริการ
            </div>
        </div>
    </AdminLayout>
</template>
