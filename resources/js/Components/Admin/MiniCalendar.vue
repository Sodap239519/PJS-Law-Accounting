<script setup>
import { computed } from 'vue';

const props = defineProps({
    monthLabel: { type: String, default: '' },
    daysInMonth: { type: Number, default: 30 },
    startWeekday: { type: Number, default: 0 }, // 0 = อาทิตย์
    today: { type: [Number, null], default: null },
    events: { type: Object, default: () => ({}) }, // { day: count }
});

const weekdays = ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'];

const cells = computed(() => {
    const arr = [];
    for (let i = 0; i < props.startWeekday; i++) arr.push(null);
    for (let d = 1; d <= props.daysInMonth; d++) arr.push(d);
    return arr;
});
</script>

<template>
    <div>
        <div class="mb-2 text-center text-sm font-semibold capitalize text-slate-700">{{ monthLabel }}</div>
        <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-medium text-slate-400">
            <div v-for="w in weekdays" :key="w">{{ w }}</div>
        </div>
        <div class="mt-1 grid grid-cols-7 gap-1">
            <div
                v-for="(d, i) in cells"
                :key="i"
                class="relative flex h-7 items-center justify-center rounded-lg text-xs"
                :class="d === today ? 'bg-pjs-blue font-semibold text-white' : d ? 'text-slate-600 hover:bg-slate-50' : ''"
            >
                <template v-if="d">
                    {{ d }}
                    <span
                        v-if="events[d]"
                        class="absolute bottom-1 h-1 w-1 rounded-full"
                        :class="d === today ? 'bg-white' : 'bg-pjs-blue'"
                    ></span>
                </template>
            </div>
        </div>
        <p class="mt-2 flex items-center justify-center gap-1.5 text-[10px] text-slate-400">
            <span class="h-1.5 w-1.5 rounded-full bg-pjs-blue"></span> วันที่มีประชาสัมพันธ์
        </p>
    </div>
</template>
