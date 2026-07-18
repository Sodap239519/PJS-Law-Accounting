<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    announcements: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');

const applyFilters = () => {
    router.get(route('admin.announcements.index'), { search: search.value, status: status.value }, { preserveState: true, replace: true });
};

const destroy = (id) => {
    if (confirm('ยืนยันการลบรายการนี้?')) router.delete(route('admin.announcements.destroy', id));
};

const statusMeta = {
    published: { label: 'เผยแพร่แล้ว', class: 'bg-pjs-blue/10 text-pjs-blue-dark' },
    scheduled: { label: 'ตั้งเวลา', class: 'bg-amber-100 text-amber-700' },
    draft: { label: 'ร่าง', class: 'bg-slate-100 text-slate-500' },
};
</script>

<template>
    <Head title="ประชาสัมพันธ์" />
    <AdminLayout>
        <template #title>ประชาสัมพันธ์</template>

        <div class="mb-4 flex flex-wrap items-center gap-3">
            <div class="flex flex-wrap gap-2">
                <input v-model="search" type="text" placeholder="ค้นหาหัวข้อ..." class="rounded-lg border-slate-200 text-sm" @keyup.enter="applyFilters" />
                <select v-model="status" class="rounded-lg border-slate-200 text-sm" @change="applyFilters">
                    <option value="">ทุกสถานะ</option>
                    <option value="published">เผยแพร่แล้ว</option>
                    <option value="scheduled">ตั้งเวลา</option>
                    <option value="draft">ฉบับร่าง</option>
                </select>
                <button class="rounded-lg border px-3 py-2 text-sm" @click="applyFilters">ค้นหา</button>
            </div>
            <Link :href="route('admin.announcements.calendar')" class="btn-outline btn-sm ml-auto"><i class="bi bi-calendar3"></i> ปฏิทิน</Link>
            <Link :href="route('admin.announcements.create')" class="btn-primary btn-sm">+ เพิ่มประชาสัมพันธ์</Link>
        </div>

        <!-- มือถือ: การ์ด -->
        <div class="space-y-2 sm:hidden">
            <div v-for="item in announcements.data" :key="item.id" class="flex gap-3 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
                <img v-if="item.cover" :src="item.cover" class="h-16 w-12 shrink-0 rounded object-cover" />
                <div v-else class="h-16 w-12 shrink-0 rounded bg-slate-100"></div>
                <div class="min-w-0 flex-1">
                    <p class="line-clamp-2 text-sm font-medium text-slate-800">{{ item.title }}</p>
                    <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-0.5 text-xs text-slate-500">
                        <span :class="item.is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="rounded-full px-2 py-0.5">{{ item.is_published ? 'เผยแพร่' : 'ร่าง' }}</span>
                        <span>{{ item.category || '-' }}</span>
                        <span>· {{ item.published_at || '-' }}</span>
                        <span>· <i class="bi bi-eye"></i> {{ item.views }}</span>
                    </div>
                    <div class="mt-2 flex gap-4 text-sm">
                        <Link :href="route('admin.announcements.edit', item.id)" class="text-pjs-blue">แก้ไข</Link>
                        <button class="text-red-500" @click="destroy(item.id)">ลบ</button>
                    </div>
                </div>
            </div>
            <p v-if="!announcements.data.length" class="rounded-xl border border-slate-100 bg-white py-10 text-center text-sm text-slate-400">ยังไม่มีรายการ</p>
        </div>

        <!-- เดสก์ท็อป: ตาราง -->
        <div class="hidden overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm sm:block">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3">ปก</th>
                            <th class="px-4 py-3">หัวข้อ</th>
                            <th class="px-4 py-3">หมวดหมู่</th>
                            <th class="px-4 py-3">สถานะ</th>
                            <th class="px-4 py-3">วันที่</th>
                            <th class="px-4 py-3 text-center">วิว</th>
                            <th class="px-4 py-3 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr v-for="item in announcements.data" :key="item.id" class="hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <img v-if="item.cover" :src="item.cover" class="h-14 w-11 rounded object-cover" />
                                <div v-else class="h-14 w-11 rounded bg-slate-100"></div>
                            </td>
                            <td class="px-4 py-2 font-medium text-slate-800">{{ item.title }}</td>
                            <td class="px-4 py-2 text-slate-500">{{ item.category || '-' }}</td>
                            <td class="px-4 py-2">
                                <span :class="(statusMeta[item.status] || statusMeta.draft).class" class="rounded-full px-2 py-0.5 text-xs">
                                    {{ (statusMeta[item.status] || statusMeta.draft).label }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-slate-500">{{ item.published_at || '-' }}</td>
                            <td class="px-4 py-2 text-center text-slate-500">{{ item.views }}</td>
                            <td class="px-4 py-2 text-right">
                                <Link :href="route('admin.announcements.edit', item.id)" class="text-pjs-blue hover:underline">แก้ไข</Link>
                                <button class="ml-3 text-red-500 hover:underline" @click="destroy(item.id)">ลบ</button>
                            </td>
                        </tr>
                        <tr v-if="!announcements.data.length">
                            <td colspan="7" class="px-4 py-10 text-center text-slate-400">ยังไม่มีรายการ</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="announcements.links && announcements.links.length > 3" class="mt-4 flex flex-wrap gap-1">
            <component
                :is="link.url ? Link : 'span'"
                v-for="(link, i) in announcements.links"
                :key="i"
                :href="link.url"
                class="rounded border px-3 py-1 text-sm"
                :class="link.active ? 'bg-pjs-blue text-white' : link.url ? 'bg-white text-slate-600 hover:bg-slate-50' : 'text-slate-300'"
                v-html="link.label"
            />
        </div>
    </AdminLayout>
</template>
