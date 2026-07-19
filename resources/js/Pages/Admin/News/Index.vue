<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    news: { type: Object, required: true },
    filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');
const perPage = ref(Number(props.filters.per_page) || 10);
const searching = ref(false);

let timer = null;
watch([search, status, perPage], () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
        window.__pjsSilentNav = true; // ค้นหาเงียบ ไม่ขึ้น overlay ขัดจังหวะ
        searching.value = true;
        router.get(route('admin.news.index'), { search: search.value, status: status.value, per_page: perPage.value }, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onFinish: () => (searching.value = false),
        });
    }, 300);
});

const destroy = (id) => {
    if (confirm('ยืนยันการลบข่าวนี้?')) router.delete(route('admin.news.destroy', id));
};

const togglePublish = (item) => {
    item.is_published = !item.is_published; // สลับทันที (optimistic)
    window.__pjsSilentNav = true;
    router.patch(route('admin.news.toggle', item.id), {}, {
        preserveScroll: true,
        preserveState: true,
        onError: () => (item.is_published = !item.is_published), // ย้อนกลับถ้าพลาด
    });
};
</script>

<template>
    <Head title="ข่าวสารและกิจกรรม" />
    <AdminLayout>
        <template #title>ข่าวสารและกิจกรรม</template>

        <!-- แถบค้นหา (พิมพ์แล้วค้นทันที) + ปุ่มเพิ่ม -->
        <div class="mb-3 flex flex-wrap items-center gap-2">
            <div class="relative min-w-0 flex-1">
                <i class="bi bi-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input v-model="search" type="text" placeholder="ค้นหาหัวข้อ…" class="field w-full pl-9 pr-9" />
                <i v-if="searching" class="bi bi-arrow-repeat absolute right-3 top-1/2 -translate-y-1/2 animate-spin text-pjs-blue/70"></i>
            </div>
            <select v-model="status" class="field w-auto shrink-0">
                <option value="">ทุกสถานะ</option>
                <option value="published">เผยแพร่แล้ว</option>
                <option value="draft">ฉบับร่าง</option>
            </select>
            <Link :href="route('admin.news.create')" class="btn-primary btn-sm shrink-0"><i class="bi bi-plus-lg"></i> เพิ่มข่าว</Link>
        </div>

        <!-- นับจำนวน + จำนวนต่อหน้า -->
        <div class="mb-2 flex items-center justify-between px-1 text-xs text-slate-400">
            <span>ทั้งหมด {{ news.total }} รายการ</span>
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

        <!-- รายการ (การ์ด + เลขลำดับ + การ์ดปุ่มแยก) -->
        <div class="space-y-2">
            <div v-for="(item, i) in news.data" :key="item.id" class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-white p-2.5 shadow-sm">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-medium text-slate-400">{{ news.from + i }}</span>
                <img v-if="item.cover" :src="item.cover" class="h-12 w-16 shrink-0 rounded-lg object-cover sm:h-11 sm:w-16" />
                <div v-else class="flex h-12 w-16 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-300 sm:h-11"><i class="bi bi-image"></i></div>

                <div class="min-w-0 flex-1">
                    <p class="line-clamp-1 text-sm font-medium text-slate-800">{{ item.title }}</p>
                    <div class="mt-0.5 flex flex-wrap items-center gap-x-2 gap-y-0.5 text-[11px] text-slate-500">
                        <span>{{ item.category || '-' }}</span>
                        <span class="hidden sm:inline">· {{ item.published_at || '-' }}</span>
                        <span>· <i class="bi bi-eye"></i> {{ item.views }}</span>
                    </div>
                </div>

                <!-- สวิตช์เผยแพร่ (ก่อนปุ่มแก้ไข) -->
                <button
                    type="button"
                    class="flex shrink-0 items-center gap-1.5 text-[11px] font-medium"
                    :class="item.is_published ? 'text-green-700' : 'text-slate-400'"
                    :title="item.is_published ? 'กำลังเผยแพร่ — คลิกเพื่อเปลี่ยนเป็นฉบับร่าง' : 'ฉบับร่าง — คลิกเพื่อเผยแพร่'"
                    @click="togglePublish(item)"
                >
                    <span :class="item.is_published ? 'bg-green-500' : 'bg-slate-300'" class="relative inline-flex h-4 w-7 shrink-0 items-center rounded-full transition-colors">
                        <span :class="item.is_published ? 'translate-x-3.5' : 'translate-x-0.5'" class="inline-block h-3 w-3 rounded-full bg-white shadow transition-transform"></span>
                    </span>
                    <span class="hidden sm:inline">{{ item.is_published ? 'เผยแพร่' : 'ฉบับร่าง' }}</span>
                </button>

                <!-- การ์ดปุ่มจัดการ (แยกออกมา) -->
                <div class="flex shrink-0 items-center gap-0.5 rounded-lg border border-slate-100 bg-slate-50/60 p-0.5">
                    <Link :href="route('admin.news.edit', item.id)" class="flex h-8 w-8 items-center justify-center rounded-md text-pjs-blue hover:bg-white" title="แก้ไข"><i class="bi bi-pencil"></i></Link>
                    <button class="flex h-8 w-8 items-center justify-center rounded-md text-red-500 hover:bg-white" title="ลบ" @click="destroy(item.id)"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <p v-if="!news.data.length" class="rounded-xl border border-slate-100 bg-white py-10 text-center text-sm text-slate-400">ยังไม่มีข่าว</p>
        </div>

        <!-- Pagination -->
        <div v-if="news.links && news.links.length > 3" class="mt-4 flex flex-wrap justify-center gap-1">
            <component
                :is="link.url ? Link : 'span'"
                v-for="(link, i) in news.links"
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
