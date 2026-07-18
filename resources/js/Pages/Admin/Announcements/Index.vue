<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    announcements: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');
const perPage = ref(Number(props.filters.per_page) || 10);

let timer = null;
watch([search, status, perPage], () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
        router.get(route('admin.announcements.index'), { search: search.value, status: status.value, per_page: perPage.value }, { preserveState: true, replace: true });
    }, 300);
});

const destroy = (id) => {
    if (confirm('ยืนยันการลบรายการนี้?')) router.delete(route('admin.announcements.destroy', id));
};

const statusMeta = {
    published: { label: 'เผยแพร่', class: 'bg-pjs-blue/10 text-pjs-blue-dark' },
    scheduled: { label: 'ตั้งเวลา', class: 'bg-amber-100 text-amber-700' },
    draft: { label: 'ร่าง', class: 'bg-slate-100 text-slate-500' },
};
</script>

<template>
    <Head title="ประชาสัมพันธ์" />
    <AdminLayout>
        <template #title>ประชาสัมพันธ์</template>

        <div class="mb-3 flex flex-wrap items-center gap-2">
            <div class="relative min-w-0 flex-1">
                <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input v-model="search" type="text" placeholder="ค้นหาหัวข้อ…" class="field w-full pl-9" />
            </div>
            <select v-model="status" class="field w-auto shrink-0">
                <option value="">ทุกสถานะ</option>
                <option value="published">เผยแพร่แล้ว</option>
                <option value="scheduled">ตั้งเวลา</option>
                <option value="draft">ฉบับร่าง</option>
            </select>
            <Link :href="route('admin.announcements.calendar')" class="btn-outline btn-sm shrink-0"><i class="bi bi-calendar3"></i></Link>
            <Link :href="route('admin.announcements.create')" class="btn-primary btn-sm shrink-0"><i class="bi bi-plus-lg"></i> เพิ่ม</Link>
        </div>

        <div class="mb-2 flex items-center justify-between px-1 text-xs text-slate-400">
            <span>ทั้งหมด {{ announcements.total }} รายการ</span>
            <label class="flex items-center gap-1.5">แสดง
                <select v-model.number="perPage" class="rounded-lg border-slate-200 py-1 pl-2 pr-6 text-xs">
                    <option :value="10">10</option>
                    <option :value="20">20</option>
                    <option :value="50">50</option>
                    <option :value="100">100</option>
                </select>
                ต่อหน้า
            </label>
        </div>

        <div class="space-y-2">
            <div v-for="(item, i) in announcements.data" :key="item.id" class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-white p-2.5 shadow-sm">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-medium text-slate-400">{{ announcements.from + i }}</span>
                <img v-if="item.cover" :src="item.cover" class="h-14 w-11 shrink-0 rounded-lg object-cover" />
                <div v-else class="flex h-14 w-11 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-300"><i class="bi bi-image"></i></div>

                <div class="min-w-0 flex-1">
                    <p class="line-clamp-1 text-sm font-medium text-slate-800">{{ item.title }}</p>
                    <div class="mt-0.5 flex flex-wrap items-center gap-x-2 gap-y-0.5 text-[11px] text-slate-500">
                        <span :class="(statusMeta[item.status] || statusMeta.draft).class" class="rounded-full px-1.5 py-0.5">{{ (statusMeta[item.status] || statusMeta.draft).label }}</span>
                        <span>{{ item.category || '-' }}</span>
                        <span class="hidden sm:inline">· {{ item.published_at || '-' }}</span>
                        <span>· <i class="bi bi-eye"></i> {{ item.views }}</span>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-0.5 rounded-lg border border-slate-100 bg-slate-50/60 p-0.5">
                    <Link :href="route('admin.announcements.edit', item.id)" class="flex h-8 w-8 items-center justify-center rounded-md text-pjs-blue hover:bg-white" title="แก้ไข"><i class="bi bi-pencil"></i></Link>
                    <button class="flex h-8 w-8 items-center justify-center rounded-md text-red-500 hover:bg-white" title="ลบ" @click="destroy(item.id)"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <p v-if="!announcements.data.length" class="rounded-xl border border-slate-100 bg-white py-10 text-center text-sm text-slate-400">ยังไม่มีรายการ</p>
        </div>

        <div v-if="announcements.links && announcements.links.length > 3" class="mt-4 flex flex-wrap justify-center gap-1">
            <component
                :is="link.url ? Link : 'span'"
                v-for="(link, i) in announcements.links"
                :key="i"
                :href="link.url"
                preserve-scroll
                class="min-w-[34px] rounded-lg border px-2.5 py-1 text-center text-sm"
                :class="link.active ? 'border-pjs-blue bg-pjs-blue text-white' : link.url ? 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' : 'border-slate-100 text-slate-300'"
                v-html="link.label"
            />
        </div>
    </AdminLayout>
</template>
