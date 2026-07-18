<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    cases: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');

const applyFilters = () => {
    router.get(route('admin.case-studies.index'), { search: search.value, status: status.value }, { preserveState: true, replace: true });
};

const destroy = (id) => {
    if (confirm('ยืนยันการลบคดีนี้?')) router.delete(route('admin.case-studies.destroy', id));
};
</script>

<template>
    <Head title="คดีตัวอย่าง" />
    <AdminLayout>
        <template #title>คดีตัวอย่าง</template>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <div class="flex flex-wrap gap-2">
                <input v-model="search" type="text" placeholder="ค้นหาหัวข้อ..." class="rounded-lg border-slate-200 text-sm" @keyup.enter="applyFilters" />
                <select v-model="status" class="rounded-lg border-slate-200 text-sm" @change="applyFilters">
                    <option value="">ทุกสถานะ</option>
                    <option value="published">เผยแพร่แล้ว</option>
                    <option value="draft">ฉบับร่าง</option>
                </select>
                <button class="rounded-lg border px-3 py-2 text-sm" @click="applyFilters">ค้นหา</button>
            </div>
            <Link :href="route('admin.case-studies.create')" class="btn-primary ml-auto">+ เพิ่มคดีตัวอย่าง</Link>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3">ปก</th>
                            <th class="px-4 py-3">หัวข้อ</th>
                            <th class="px-4 py-3">ลูกความ</th>
                            <th class="px-4 py-3">หมวดหมู่</th>
                            <th class="px-4 py-3">สถานะ</th>
                            <th class="px-4 py-3 text-center">วิว</th>
                            <th class="px-4 py-3 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="item in cases.data" :key="item.id" class="hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <img v-if="item.cover" :src="item.cover" class="h-10 w-16 rounded object-cover" />
                                <div v-else class="h-10 w-16 rounded bg-slate-100"></div>
                            </td>
                            <td class="px-4 py-2 font-medium text-slate-800">{{ item.title }}</td>
                            <td class="px-4 py-2 text-slate-500">{{ item.client_name || '-' }}</td>
                            <td class="px-4 py-2 text-slate-500">{{ item.category || '-' }}</td>
                            <td class="px-4 py-2">
                                <span :class="item.is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="rounded-full px-2 py-0.5 text-xs">
                                    {{ item.is_published ? 'เผยแพร่' : 'ร่าง' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center text-slate-500">{{ item.views }}</td>
                            <td class="px-4 py-2 text-right">
                                <Link :href="route('admin.case-studies.edit', item.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                                <button class="ml-3 text-red-500 hover:underline" @click="destroy(item.id)">ลบ</button>
                            </td>
                        </tr>
                        <tr v-if="!cases.data.length">
                            <td colspan="7" class="px-4 py-10 text-center text-slate-400">ยังไม่มีคดีตัวอย่าง</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="cases.links && cases.links.length > 3" class="mt-4 flex flex-wrap gap-1">
            <component
                :is="link.url ? Link : 'span'"
                v-for="(link, i) in cases.links"
                :key="i"
                :href="link.url"
                class="rounded border px-3 py-1 text-sm"
                :class="link.active ? 'bg-pjs-blue text-white' : link.url ? 'bg-white text-slate-600 hover:bg-slate-50' : 'text-slate-300'"
                v-html="link.label"
            />
        </div>
    </AdminLayout>
</template>
