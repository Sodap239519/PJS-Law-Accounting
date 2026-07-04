<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: { type: Object, default: () => ({}) },
    meta: { type: Object, default: () => ({}) },
    contentByType: { type: Array, default: () => [] },
    recentNews: { type: Array, default: () => [] },
});

const user = computed(() => usePage().props.auth?.user || {});
const roleLabel = computed(() => (user.value.role === 'super_admin' ? 'Super Admin' : 'ผู้ดูแลระบบ'));
const initials = computed(() => (user.value.name || '?').trim().charAt(0).toUpperCase());

const maxCount = computed(() => Math.max(...props.contentByType.map((c) => c.value), 1));

const R = 42;
const CIRC = 2 * Math.PI * R;
const publishRatio = computed(() => {
    const total = props.stats.news || 0;
    return total ? (props.meta.publishedNews || 0) / total : 0;
});
const dash = computed(() => `${publishRatio.value * CIRC} ${CIRC}`);

const hasRoute = (n) => route().has(n);

const bigStats = computed(() => [
    { label: 'เนื้อหาทั้งหมด', value: props.meta.totalContent ?? 0, icon: 'bi bi-collection' },
    { label: 'ยอดเข้าชมรวม', value: (props.meta.totalViews ?? 0).toLocaleString(), icon: 'bi bi-eye' },
    { label: 'บุคลากร', value: props.stats.team ?? 0, icon: 'bi bi-people' },
]);

const tasks = computed(() => [
    { label: 'ข้อความรอตอบกลับ', value: props.stats.unreadContacts ?? 0, route: 'admin.contacts.index', icon: 'bi bi-envelope' },
    { label: 'ข่าวฉบับร่าง', value: props.meta.draftNews ?? 0, route: 'admin.news.index', icon: 'bi bi-file-earmark' },
    { label: 'แบนเนอร์บนหน้าแรก', value: props.stats.banners ?? 0, route: 'admin.banners.index', icon: 'bi bi-image' },
]);

const quickActions = [
    { label: 'เพิ่มข่าว', route: 'admin.news.create', icon: 'bi bi-newspaper' },
    { label: 'เพิ่มประชาสัมพันธ์', route: 'admin.announcements.create', icon: 'bi bi-megaphone' },
    { label: 'เพิ่มคดีตัวอย่าง', route: 'admin.case-studies.create', icon: 'bi bi-bank' },
];
</script>

<template>
    <Head title="แดชบอร์ด" />
    <AdminLayout>
        <template #title>แดชบอร์ด</template>

        <!-- Welcome -->
        <div class="mb-5">
            <h2 class="text-2xl font-bold text-slate-800 sm:text-3xl">ยินดีต้อนรับ, {{ user.name }}</h2>
            <p class="mt-1 text-sm text-slate-500">ภาพรวมการจัดการเว็บไซต์ PJS Law &amp; Accounting</p>
        </div>

        <div class="grid grid-cols-12 gap-4">
            <!-- Profile card -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-4 lg:row-span-2">
                <div class="flex h-full flex-col overflow-hidden rounded-3xl bg-gradient-to-br from-pjs-navy to-pjs-blue text-white shadow-soft">
                    <div class="flex flex-1 flex-col items-center justify-center px-6 pt-8">
                        <img v-if="user.avatar" :src="user.avatar" class="h-28 w-28 rounded-full object-cover ring-4 ring-white/20" />
                        <div v-else class="flex h-28 w-28 items-center justify-center rounded-full bg-white/15 text-4xl font-bold ring-4 ring-white/20">
                            {{ initials }}
                        </div>
                        <h3 class="mt-4 text-lg font-bold">{{ user.name }}</h3>
                        <span class="mt-1 rounded-full bg-white/15 px-3 py-0.5 text-xs">{{ roleLabel }}</span>
                    </div>
                    <div class="m-4 flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 backdrop-blur">
                        <div>
                            <p class="text-xs text-blue-100/70">จัดการเนื้อหา</p>
                            <p class="text-lg font-bold">{{ meta.totalContent ?? 0 }} รายการ</p>
                        </div>
                        <Link :href="route('profile.edit')" class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 hover:bg-white/25">
                            <i class="bi bi-pencil text-sm"></i>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Big stats -->
            <div class="col-span-12 lg:col-span-8">
                <div class="grid h-full grid-cols-1 gap-4 sm:grid-cols-3">
                    <div v-for="s in bigStats" :key="s.label" class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-pjs-blue/10 text-pjs-blue">
                            <i :class="s.icon" class="text-xl"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-2xl font-bold text-pjs-navy">{{ s.value }}</p>
                            <p class="truncate text-xs text-slate-400">{{ s.label }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content bar chart -->
            <div class="col-span-12 lg:col-span-8">
                <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 font-semibold text-slate-800">เนื้อหาแยกประเภท</h3>
                    <div class="space-y-3.5">
                        <component
                            :is="hasRoute(row.route) ? Link : 'div'"
                            v-for="row in contentByType"
                            :key="row.label"
                            :href="hasRoute(row.route) ? route(row.route) : undefined"
                            class="block"
                        >
                            <div class="mb-1 flex items-center justify-between text-sm">
                                <span class="text-slate-600">{{ row.label }}</span>
                                <span class="font-semibold text-slate-800">{{ row.value }}</span>
                            </div>
                            <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-gradient-to-r from-pjs-blue to-pjs-blue-light transition-all duration-500" :style="{ width: (row.value / maxCount) * 100 + '%' }"></div>
                            </div>
                        </component>
                    </div>
                </div>
            </div>

            <!-- Donut -->
            <div class="col-span-6 lg:col-span-4">
                <div class="flex h-full flex-col items-center justify-center rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-2 self-start font-semibold text-slate-800">สถานะข่าว</h3>
                    <div class="relative">
                        <svg width="130" height="130" viewBox="0 0 100 100" class="-rotate-90">
                            <circle cx="50" cy="50" :r="R" fill="none" stroke="#e2e8f0" stroke-width="9" />
                            <circle cx="50" cy="50" :r="R" fill="none" stroke="#2563eb" stroke-width="9" stroke-linecap="round" :stroke-dasharray="dash" class="transition-all duration-700" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-pjs-navy">{{ Math.round(publishRatio * 100) }}%</span>
                            <span class="text-[10px] text-slate-400">เผยแพร่</span>
                        </div>
                    </div>
                    <div class="mt-2 flex gap-4 text-xs">
                        <span class="flex items-center gap-1 text-slate-500"><span class="h-2 w-2 rounded-full bg-pjs-blue"></span>เผยแพร่ {{ meta.publishedNews ?? 0 }}</span>
                        <span class="flex items-center gap-1 text-slate-500"><span class="h-2 w-2 rounded-full bg-slate-300"></span>ร่าง {{ meta.draftNews ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Dark task card -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                <div class="h-full rounded-2xl bg-pjs-navy p-6 text-white shadow-soft">
                    <h3 class="mb-4 font-semibold">สิ่งที่ต้องจัดการ</h3>
                    <ul class="space-y-2.5">
                        <component
                            :is="hasRoute(t.route) ? Link : 'div'"
                            v-for="t in tasks"
                            :key="t.label"
                            :href="hasRoute(t.route) ? route(t.route) : undefined"
                            class="flex items-center gap-3 rounded-xl bg-white/5 px-3 py-2.5 text-sm transition hover:bg-white/10"
                        >
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10"><i :class="t.icon"></i></span>
                            <span class="flex-1 text-blue-100/90">{{ t.label }}</span>
                            <span class="rounded-full bg-pjs-blue px-2 py-0.5 text-xs font-semibold">{{ t.value }}</span>
                        </component>
                    </ul>
                </div>
            </div>

            <!-- Recent news -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                <div class="h-full rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="font-semibold text-slate-800">ข่าวล่าสุด</h3>
                        <Link v-if="hasRoute('admin.news.index')" :href="route('admin.news.index')" class="text-xs text-pjs-blue hover:underline">ดูทั้งหมด</Link>
                    </div>
                    <ul class="divide-y divide-slate-100">
                        <li v-for="n in recentNews.slice(0, 4)" :key="n.id" class="flex items-center gap-3 py-2">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-pjs-blue/10 text-pjs-blue"><i class="bi bi-newspaper text-sm"></i></span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-700">{{ n.title }}</p>
                                <p class="text-xs text-slate-400">{{ n.date }} · {{ n.views }} วิว</p>
                            </div>
                        </li>
                        <li v-if="!recentNews.length" class="py-8 text-center text-sm text-slate-400">ยังไม่มีข่าว</li>
                    </ul>
                </div>
            </div>

            <!-- Quick actions -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                <div class="h-full rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-3 font-semibold text-slate-800">ทางลัด</h3>
                    <div class="space-y-2">
                        <Link
                            v-for="a in quickActions"
                            :key="a.route"
                            :href="hasRoute(a.route) ? route(a.route) : '#'"
                            class="flex items-center gap-3 rounded-xl border border-slate-100 px-3 py-2.5 text-sm text-slate-600 transition hover:border-pjs-blue/30 hover:bg-pjs-blue/5"
                        >
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-pjs-blue/10 text-pjs-blue"><i :class="a.icon"></i></span>
                            {{ a.label }}
                            <i class="bi bi-chevron-right ml-auto text-xs text-slate-300"></i>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
