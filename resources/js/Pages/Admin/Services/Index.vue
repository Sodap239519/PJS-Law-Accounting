<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    services: { type: Array, default: () => [] },
});

const destroy = (id) => {
    if (confirm('ยืนยันการลบบริการนี้?')) router.delete(route('admin.services.destroy', id));
};
</script>

<template>
    <Head title="บริการ" />
    <AdminLayout>
        <template #title>บริการ</template>

        <div class="mb-4">
            <Link :href="route('admin.services.create')" class="rounded-lg bg-pjs-blue px-4 py-2 text-sm font-medium text-white hover:bg-pjs-blue-dark">
                + เพิ่มบริการ
            </Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <table class="min-w-full divide-y text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-4 py-3 text-center">ลำดับ</th>
                        <th class="px-4 py-3">ไอคอน</th>
                        <th class="px-4 py-3">ชื่อบริการ</th>
                        <th class="px-4 py-3">สถานะ</th>
                        <th class="px-4 py-3 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr v-for="item in services" :key="item.id" class="hover:bg-slate-50">
                        <td class="px-4 py-2 text-center text-slate-400">{{ item.sort_order }}</td>
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
                    <tr v-if="!services.length">
                        <td colspan="5" class="px-4 py-10 text-center text-slate-400">ยังไม่มีบริการ</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
