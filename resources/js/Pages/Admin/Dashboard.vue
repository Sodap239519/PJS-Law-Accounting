<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import LineChart from '@/Components/Admin/LineChart.vue';
import MiniCalendar from '@/Components/Admin/MiniCalendar.vue';

const props = defineProps({
    stats: { type: Object, default: () => ({}) },
    meta: { type: Object, default: () => ({}) },
    contentByType: { type: Array, default: () => [] },
    recentNews: { type: Array, default: () => [] },
    chart: { type: Object, default: () => ({ labels: [], views: [], messages: [] }) },
    prCalendar: { type: Object, default: () => ({}) },
});

const user = computed(() => usePage().props.auth?.user || {});
const roleLabel = computed(() => (user.value.role === 'super_admin' ? 'Super Admin' : 'ผู้ดูแลระบบ'));
const initials = computed(() => (user.value.name || '?').trim().charAt(0).toUpperCase());

const maxCount = computed(() => Math.max(...props.contentByType.map((c) => c.value), 1));
const hasRoute = (n) => route().has(n);

const bigStats = computed(() => [
    { label: 'เนื้อหาทั้งหมด', value: props.meta.totalContent ?? 0 },
    { label: 'ยอดเข้าชม', value: (props.meta.totalViews ?? 0).toLocaleString() },
    { label: 'บุคลากร', value: props.stats.team ?? 0 },
]);

const chartSeries = computed(() => [
    { name: 'ผู้เข้าชม', color: '#2563eb', data: props.chart.views || [] },
    { name: 'ข้อความ', color: '#f59e0b', data: props.chart.messages || [] },
]);

const tasks = computed(() => [
    { label: 'ข้อความรอตอบ', value: props.stats.unreadContacts ?? 0, route: 'admin.contacts.index', icon: 'bi bi-envelope' },
    { label: 'ข่าวฉบับร่าง', value: props.meta.draftNews ?? 0, route: 'admin.news.index', icon: 'bi bi-file-earmark' },
    { label: 'แบนเนอร์', value: props.stats.banners ?? 0, route: 'admin.banners.index', icon: 'bi bi-image' },
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

        <!-- Welcome + big numbers -->
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-slate-800">ยินดีต้อนรับ, {{ user.name }}</h2>
                <p class="text-xs text-slate-400">ภาพรวมการจัดการเว็บไซต์</p>
            </div>
            <div class="flex gap-6">
                <div v-for="s in bigStats" :key="s.label" class="text-center">
                    <p class="text-2xl font-bold text-pjs-navy">{{ s.value }}</p>
                    <p class="text-[11px] text-slate-400">{{ s.label }}</p>
                </div>
            </div>
        </div>

        <!-- Row 1: 4 cards -->
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Profile (photo prominent) -->
            <div class="relative min-h-[15rem] overflow-hidden rounded-2xl shadow-sm">
                <img v-if="user.avatar" :src="user.avatar" class="absolute inset-0 h-full w-full object-cover" />
                <div v-else class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-pjs-blue to-pjs-blue-light">
                    <span class="text-6xl font-bold text-white/90">{{ initials }}</span>
                </div>
                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-4 pt-10 text-white">
                    <span class="mb-1 inline-block rounded-full bg-white/20 px-2 py-0.5 text-[10px] backdrop-blur">{{ roleLabel }}</span>
                    <h3 class="text-base font-bold leading-tight">{{ user.name }}</h3>
                    <Link :href="route('profile.edit')" class="mt-2 inline-flex items-center gap-1 text-xs text-white/90 hover:text-white">
                        <i class="bi bi-pencil"></i> แก้ไขโปรไฟล์
                    </Link>
                </div>
            </div>

            <!-- Line chart -->
            <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <h3 class="mb-1 text-sm font-semibold text-slate-700">ผู้เข้าชม &amp; ข้อความ (14 วัน)</h3>
                <LineChart :labels="chart.labels" :series="chartSeries" />
            </div>

            <!-- Content bars -->
            <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <h3 class="mb-3 text-sm font-semibold text-slate-700">เนื้อหาแยกประเภท</h3>
                <div class="space-y-2.5">
                    <component :is="hasRoute(row.route) ? Link : 'div'" v-for="row in contentByType" :key="row.label" :href="hasRoute(row.route) ? route(row.route) : undefined" class="block">
                        <div class="mb-0.5 flex justify-between text-[11px]"><span class="text-slate-500">{{ row.label }}</span><span class="font-semibold text-slate-700">{{ row.value }}</span></div>
                        <div class="h-1.5 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-pjs-blue transition-all duration-500" :style="{ width: (row.value / maxCount) * 100 + '%' }"></div></div>
                    </component>
                </div>
            </div>

            <!-- Tasks -->
            <div class="rounded-2xl border border-pjs-blue/15 bg-pjs-blue/5 p-4 shadow-sm">
                <h3 class="mb-3 text-sm font-semibold text-pjs-blue-dark">สิ่งที่ต้องจัดการ</h3>
                <ul class="space-y-2">
                    <component :is="hasRoute(t.route) ? Link : 'div'" v-for="t in tasks" :key="t.label" :href="hasRoute(t.route) ? route(t.route) : undefined" class="flex items-center gap-2 rounded-xl bg-white px-2.5 py-2 text-xs shadow-sm transition hover:shadow">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-pjs-blue/10 text-pjs-blue"><i :class="t.icon" class="text-xs"></i></span>
                        <span class="flex-1 text-slate-600">{{ t.label }}</span>
                        <span class="rounded-full bg-pjs-blue px-1.5 py-0.5 text-[10px] font-semibold text-white">{{ t.value }}</span>
                    </component>
                </ul>
            </div>
        </div>

        <!-- Row 2: recent | calendar | quick -->
        <div class="mt-3 grid grid-cols-1 gap-3 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-slate-700">ข่าวล่าสุด</h3>
                    <Link v-if="hasRoute('admin.news.index')" :href="route('admin.news.index')" class="text-xs text-pjs-blue hover:underline">ดูทั้งหมด</Link>
                </div>
                <ul class="divide-y divide-slate-100">
                    <li v-for="n in recentNews.slice(0, 4)" :key="n.id" class="flex items-center gap-2.5 py-1.5">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-pjs-blue/10 text-pjs-blue"><i class="bi bi-newspaper text-xs"></i></span>
                        <p class="min-w-0 flex-1 truncate text-xs font-medium text-slate-600">{{ n.title }}</p>
                        <p class="shrink-0 text-[10px] text-slate-400">{{ n.date }}</p>
                    </li>
                    <li v-if="!recentNews.length" class="py-6 text-center text-xs text-slate-400">ยังไม่มีข่าว</li>
                </ul>
            </div>

            <!-- PR Calendar -->
            <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <h3 class="mb-2 text-sm font-semibold text-slate-700">ปฏิทินการประชาสัมพันธ์</h3>
                <MiniCalendar
                    :month-label="prCalendar.monthLabel"
                    :days-in-month="prCalendar.daysInMonth"
                    :start-weekday="prCalendar.startWeekday"
                    :today="prCalendar.today"
                    :events="prCalendar.events || {}"
                />
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                <h3 class="mb-2 text-sm font-semibold text-slate-700">ทางลัด</h3>
                <div class="space-y-1.5">
                    <Link v-for="a in quickActions" :key="a.route" :href="hasRoute(a.route) ? route(a.route) : '#'" class="flex items-center gap-2.5 rounded-xl border border-slate-100 px-2.5 py-2 text-xs text-slate-600 transition hover:border-pjs-blue/30 hover:bg-pjs-blue/5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-pjs-blue/10 text-pjs-blue"><i :class="a.icon" class="text-xs"></i></span>
                        {{ a.label }}
                        <i class="bi bi-chevron-right ml-auto text-[10px] text-slate-300"></i>
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
