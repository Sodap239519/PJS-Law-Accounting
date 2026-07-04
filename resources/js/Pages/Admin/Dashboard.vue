<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: { type: Object, default: () => ({}) },
    meta: { type: Object, default: () => ({}) },
    contentByType: { type: Array, default: () => [] },
    recentNews: { type: Array, default: () => [] },
});

const maxCount = computed(() => Math.max(...props.contentByType.map((c) => c.value), 1));

// donut: สัดส่วนข่าวที่เผยแพร่แล้ว
const R = 42;
const CIRC = 2 * Math.PI * R;
const publishRatio = computed(() => {
    const total = props.stats.news || 0;
    return total ? (props.meta.publishedNews || 0) / total : 0;
});
const dash = computed(() => `${publishRatio.value * CIRC} ${CIRC}`);

const hasRoute = (n) => route().has(n);

const quickActions = [
    { label: 'เพิ่มข่าว', route: 'admin.news.create', icon: 'bi bi-newspaper' },
    { label: 'เพิ่มประชาสัมพันธ์', route: 'admin.announcements.create', icon: 'bi bi-megaphone' },
    { label: 'เพิ่มคดีตัวอย่าง', route: 'admin.case-studies.create', icon: 'bi bi-bank' },
    { label: 'เพิ่มบริการ', route: 'admin.services.create', icon: 'bi bi-briefcase' },
];
</script>

<template>
    <Head title="แดชบอร์ด" />
    <AdminLayout>
        <template #title>แดชบอร์ด</template>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <!-- Hero -->
            <div class="rounded-2xl bg-gradient-to-br from-pjs-navy to-pjs-blue p-6 text-white shadow-soft lg:col-span-2">
                <p class="text-sm text-blue-100/70">ยินดีต้อนรับกลับมา 👋</p>
                <h2 class="mt-1 text-2xl font-bold">ภาพรวมเว็บไซต์ PJS</h2>
                <div class="mt-6 grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-3xl font-bold">{{ meta.totalContent ?? 0 }}</p>
                        <p class="text-xs text-blue-100/70">เนื้อหาทั้งหมด</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">{{ (meta.totalViews ?? 0).toLocaleString() }}</p>
                        <p class="text-xs text-blue-100/70">ยอดเข้าชมรวม</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">{{ stats.team ?? 0 }}</p>
                        <p class="text-xs text-blue-100/70">บุคลากร</p>
                    </div>
                </div>
            </div>

            <!-- Unread messages -->
            <component
                :is="hasRoute('admin.contacts.index') ? Link : 'div'"
                :href="hasRoute('admin.contacts.index') ? route('admin.contacts.index') : undefined"
                class="flex flex-col justify-between rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:shadow-soft"
            >
                <div class="flex items-center justify-between">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-pjs-blue/10 text-pjs-blue">
                        <i class="bi bi-envelope text-lg"></i>
                    </span>
                    <span class="text-4xl font-bold text-pjs-navy">{{ stats.unreadContacts ?? 0 }}</span>
                </div>
                <p class="mt-4 text-sm font-medium text-slate-500">ข้อความยังไม่อ่าน</p>
            </component>

            <!-- Content by type (bars) -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-2">
                <h3 class="mb-4 font-semibold text-slate-800">เนื้อหาแยกประเภท</h3>
                <div class="space-y-3">
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
                            <div class="h-full rounded-full bg-gradient-to-r from-pjs-blue to-pjs-blue-light transition-all" :style="{ width: (row.value / maxCount) * 100 + '%' }"></div>
                        </div>
                    </component>
                </div>
            </div>

            <!-- Published donut -->
            <div class="flex flex-col items-center justify-center rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                <h3 class="mb-3 self-start font-semibold text-slate-800">สถานะข่าว</h3>
                <div class="relative">
                    <svg width="120" height="120" viewBox="0 0 100 100" class="-rotate-90">
                        <circle cx="50" cy="50" :r="R" fill="none" stroke="#e2e8f0" stroke-width="10" />
                        <circle cx="50" cy="50" :r="R" fill="none" stroke="#2563eb" stroke-width="10" stroke-linecap="round" :stroke-dasharray="dash" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-pjs-navy">{{ Math.round(publishRatio * 100) }}%</span>
                        <span class="text-[10px] text-slate-400">เผยแพร่</span>
                    </div>
                </div>
                <div class="mt-3 flex gap-4 text-xs">
                    <span class="flex items-center gap-1 text-slate-500"><span class="h-2 w-2 rounded-full bg-pjs-blue"></span>เผยแพร่ {{ meta.publishedNews ?? 0 }}</span>
                    <span class="flex items-center gap-1 text-slate-500"><span class="h-2 w-2 rounded-full bg-slate-300"></span>ร่าง {{ meta.draftNews ?? 0 }}</span>
                </div>
            </div>

            <!-- Recent news -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm lg:col-span-2">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800">ข่าวล่าสุด</h3>
                    <Link v-if="hasRoute('admin.news.index')" :href="route('admin.news.index')" class="text-sm text-pjs-blue hover:underline">ดูทั้งหมด</Link>
                </div>
                <ul class="divide-y divide-slate-100">
                    <li v-for="n in recentNews" :key="n.id" class="flex items-center gap-3 py-2.5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-pjs-blue/10 text-pjs-blue"><i class="bi bi-newspaper text-sm"></i></span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-700">{{ n.title }}</p>
                            <p class="text-xs text-slate-400">{{ n.date }} · {{ n.views }} วิว</p>
                        </div>
                        <span :class="n.is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500'" class="rounded-full px-2 py-0.5 text-xs">
                            {{ n.is_published ? 'เผยแพร่' : 'ร่าง' }}
                        </span>
                    </li>
                    <li v-if="!recentNews.length" class="py-8 text-center text-sm text-slate-400">ยังไม่มีข่าว</li>
                </ul>
            </div>

            <!-- Quick actions -->
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
                <h3 class="mb-4 font-semibold text-slate-800">ทางลัด</h3>
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
    </AdminLayout>
</template>
