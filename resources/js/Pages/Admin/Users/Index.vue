<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    users: { type: Array, default: () => [] },
    roles: { type: Object, default: () => ({}) },
});

const destroy = (user) => {
    if (confirm(`ยืนยันการลบผู้ใช้ "${user.name}"?`)) router.delete(route('admin.users.destroy', user.id));
};
</script>

<template>
    <Head title="ผู้ใช้ระบบ" />
    <AdminLayout>
        <template #title>ผู้ใช้ระบบ</template>

        <div class="mb-4 flex justify-end">
            <Link :href="route('admin.users.create')" class="btn-primary">+ เพิ่มผู้ใช้</Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3">ผู้ใช้</th>
                            <th class="px-4 py-3">อีเมล</th>
                            <th class="px-4 py-3">สิทธิ์</th>
                            <th class="px-4 py-3 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="u in users" :key="u.id" class="hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="h-9 w-9 shrink-0 overflow-hidden rounded-full bg-pjs-blue/10">
                                        <img v-if="u.avatar" :src="u.avatar" class="h-full w-full object-cover" />
                                        <span v-else class="flex h-full items-center justify-center text-pjs-blue"><i class="bi bi-person"></i></span>
                                    </span>
                                    <span class="font-medium text-slate-800">{{ u.name }}</span>
                                    <span v-if="u.is_self" class="rounded-full bg-slate-100 px-2 py-0.5 text-[10px] text-slate-500">คุณ</span>
                                </div>
                            </td>
                            <td class="px-4 py-2 text-slate-500">{{ u.email }}</td>
                            <td class="px-4 py-2">
                                <span :class="u.role === 'super_admin' ? 'bg-pjs-blue/10 text-pjs-blue-dark' : 'bg-slate-100 text-slate-600'" class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs">
                                    <i :class="u.role === 'super_admin' ? 'bi bi-shield-check' : 'bi bi-person-badge'"></i> {{ u.role_label }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <Link :href="route('admin.users.edit', u.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                                <button v-if="!u.is_self" class="ml-3 text-red-500 hover:underline" @click="destroy(u)">ลบ</button>
                            </td>
                        </tr>
                        <tr v-if="!users.length">
                            <td colspan="4" class="px-4 py-10 text-center text-slate-400">ยังไม่มีผู้ใช้</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
