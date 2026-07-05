<script setup>
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    calendar: { type: Object, required: true },
    events: { type: Object, default: () => ({}) }, // { day: [{id,title,time,status}] }
});

const weekdays = ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์'];

const cells = computed(() => {
    const arr = [];
    for (let i = 0; i < props.calendar.startWeekday; i++) arr.push(null);
    for (let d = 1; d <= props.calendar.daysInMonth; d++) arr.push(d);
    while (arr.length % 7 !== 0) arr.push(null);
    return arr;
});

const pad = (n) => String(n).padStart(2, '0');
const dateStr = (d) => `${props.calendar.year}-${pad(props.calendar.month)}-${pad(d)}`;

const goMonth = (ym) => router.get(route('admin.announcements.calendar'), { month: ym }, { preserveScroll: true });
const goToday = () => router.get(route('admin.announcements.calendar'));
const addOn = (d) => router.get(route('admin.announcements.create'), { date: dateStr(d) });
const openEvent = (id) => router.get(route('admin.announcements.edit', id));

const chipClass = (status) =>
    ({
        published: 'bg-pjs-blue/10 text-pjs-blue-dark hover:bg-pjs-blue/20',
        scheduled: 'bg-amber-100 text-amber-700 hover:bg-amber-200',
        draft: 'bg-slate-100 text-slate-500 hover:bg-slate-200',
    })[status] || 'bg-slate-100 text-slate-500';
</script>

<template>
    <Head title="ปฏิทินประชาสัมพันธ์" />
    <AdminLayout>
        <template #title>ปฏิทินประชาสัมพันธ์</template>

        <!-- Toolbar -->
        <div class="mb-4 flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-1 rounded-full border border-slate-200 bg-white p-1 shadow-sm">
                <button class="flex h-8 w-8 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100" @click="goMonth(calendar.prevMonth)"><i class="bi bi-chevron-left"></i></button>
                <span class="min-w-[9rem] text-center text-sm font-semibold text-slate-700">{{ calendar.monthLabel }}</span>
                <button class="flex h-8 w-8 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100" @click="goMonth(calendar.nextMonth)"><i class="bi bi-chevron-right"></i></button>
            </div>
            <button class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 shadow-sm hover:bg-slate-50" @click="goToday">วันนี้</button>

            <div class="ml-auto flex items-center gap-2">
                <Link :href="route('admin.announcements.index')" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600 shadow-sm hover:bg-slate-50">
                    <i class="bi bi-list-ul"></i> แบบรายการ
                </Link>
                <Link :href="route('admin.announcements.create')" class="rounded-full bg-pjs-blue px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-pjs-blue-dark">
                    <i class="bi bi-plus-lg"></i> เพิ่มประชาสัมพันธ์
                </Link>
            </div>
        </div>

        <!-- Legend -->
        <div class="mb-3 flex flex-wrap gap-4 text-xs text-slate-500">
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-pjs-blue"></span> เผยแพร่แล้ว</span>
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span> ตั้งเวลา</span>
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span> ร่าง</span>
            <span class="text-slate-400">· คลิกวันว่างเพื่อเพิ่ม · คลิกรายการเพื่อแก้ไข</span>
        </div>

        <!-- Calendar -->
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50 text-center text-xs font-medium text-slate-500">
                <div v-for="w in weekdays" :key="w" class="py-2.5">{{ w }}</div>
            </div>
            <div class="grid grid-cols-7">
                <div
                    v-for="(d, i) in cells"
                    :key="i"
                    class="group relative min-h-[104px] border-b border-r border-slate-100 p-1.5 transition"
                    :class="d ? 'cursor-pointer hover:bg-slate-50/70' : 'bg-slate-50/40'"
                    @click="d && (events[d] ? null : addOn(d))"
                >
                    <template v-if="d">
                        <div class="mb-1 flex items-center justify-between">
                            <span
                                class="flex h-6 w-6 items-center justify-center rounded-full text-xs"
                                :class="d === calendar.today ? 'bg-pjs-blue font-semibold text-white' : 'text-slate-500'"
                            >{{ d }}</span>
                            <button
                                class="flex h-5 w-5 items-center justify-center rounded-full text-slate-300 opacity-0 transition hover:bg-pjs-blue/10 hover:text-pjs-blue group-hover:opacity-100"
                                title="เพิ่มในวันนี้"
                                @click.stop="addOn(d)"
                            ><i class="bi bi-plus text-xs"></i></button>
                        </div>
                        <div class="space-y-1">
                            <button
                                v-for="ev in (events[d] || [])"
                                :key="ev.id"
                                class="block w-full truncate rounded-md px-1.5 py-1 text-left text-[11px] font-medium transition"
                                :class="chipClass(ev.status)"
                                :title="ev.title + ' · ' + ev.time"
                                @click.stop="openEvent(ev.id)"
                            >
                                <span class="opacity-70">{{ ev.time }}</span> {{ ev.title }}
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
