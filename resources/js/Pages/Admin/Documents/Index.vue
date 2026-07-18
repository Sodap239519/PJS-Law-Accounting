<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
    documents: { type: Array, default: () => [] },
});

const destroy = (id) => {
    if (confirm('ยืนยันการลบเอกสารนี้?')) router.delete(route('admin.documents.destroy', id));
};

const fileIcon = (name) => {
    const ext = (name || '').split('.').pop().toLowerCase();
    if (['pdf'].includes(ext)) return 'bi bi-file-earmark-pdf text-red-500';
    if (['doc', 'docx'].includes(ext)) return 'bi bi-file-earmark-word text-blue-600';
    if (['xls', 'xlsx'].includes(ext)) return 'bi bi-file-earmark-excel text-green-600';
    if (['ppt', 'pptx'].includes(ext)) return 'bi bi-file-earmark-ppt text-orange-500';
    if (['jpg', 'jpeg', 'png'].includes(ext)) return 'bi bi-file-earmark-image text-purple-500';
    return 'bi bi-file-earmark text-slate-400';
};
</script>

<template>
    <Head title="เอกสารดาวน์โหลด" />
    <AdminLayout>
        <template #title>เอกสารดาวน์โหลด</template>

        <div class="mb-4 flex justify-end">
            <Link :href="route('admin.documents.create')" class="btn-primary">+ เพิ่มเอกสาร</Link>
        </div>

        <!-- มือถือ: การ์ด -->
        <div class="space-y-2 sm:hidden">
            <div v-for="item in documents" :key="item.id" class="rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
                <p class="line-clamp-2 text-sm font-medium text-slate-800"><i class="bi bi-file-earmark-text text-pjs-blue/60"></i> {{ item.title }}</p>
                <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-0.5 text-xs text-slate-500">
                    <span :class="item.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="rounded-full px-2 py-0.5">{{ item.is_active ? 'เผยแพร่' : 'ปิด' }}</span>
                    <span>{{ item.category || '-' }}</span>
                    <span>· <i class="bi bi-download"></i> {{ item.downloads }}</span>
                </div>
                <div class="mt-2 flex gap-4 text-sm">
                    <Link :href="route('admin.documents.edit', item.id)" class="text-pjs-blue">แก้ไข</Link>
                    <button class="text-red-500" @click="destroy(item.id)">ลบ</button>
                </div>
            </div>
            <p v-if="!documents.length" class="rounded-xl border border-slate-100 bg-white py-10 text-center text-sm text-slate-400">ยังไม่มีเอกสาร</p>
        </div>

        <!-- เดสก์ท็อป: ตาราง -->
        <div class="hidden overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm sm:block">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3">เอกสาร</th>
                            <th class="px-4 py-3">หมวดหมู่</th>
                            <th class="px-4 py-3 text-center">ดาวน์โหลด</th>
                            <th class="px-4 py-3">สถานะ</th>
                            <th class="px-4 py-3 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="item in documents" :key="item.id" class="hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-2.5">
                                    <i :class="fileIcon(item.file?.name)" class="text-2xl"></i>
                                    <div class="min-w-0">
                                        <p class="truncate font-medium text-slate-800">{{ item.title }}</p>
                                        <p v-if="item.file" class="truncate text-xs text-slate-400">{{ item.file.name }} · {{ item.file.size }}</p>
                                        <p v-else class="text-xs text-amber-500">ยังไม่มีไฟล์</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 text-slate-500">{{ item.category || '-' }}</td>
                            <td class="px-4 py-2 text-center text-slate-500">{{ item.downloads }}</td>
                            <td class="px-4 py-2">
                                <span :class="item.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="rounded-full px-2 py-0.5 text-xs">
                                    {{ item.is_active ? 'เผยแพร่' : 'ปิด' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right">
                                <Link :href="route('admin.documents.edit', item.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                                <button class="ml-3 text-red-500 hover:underline" @click="destroy(item.id)">ลบ</button>
                            </td>
                        </tr>
                        <tr v-if="!documents.length">
                            <td colspan="5" class="px-4 py-10 text-center text-slate-400">ยังไม่มีเอกสาร</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
