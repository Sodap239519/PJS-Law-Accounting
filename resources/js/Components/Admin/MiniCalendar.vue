<script setup>
import { computed } from 'vue';

const props = defineProps({
    monthLabel: { type: String, default: '' },
    year: { type: Number, default: 0 },
    month: { type: Number, default: 0 },
    daysInMonth: { type: Number, default: 30 },
    startWeekday: { type: Number, default: 0 }, // 0 = อาทิตย์
    today: { type: [Number, null], default: null },
    events: { type: Object, default: () => ({}) }, // { day: count }
    clickable: { type: Boolean, default: true },
});

const emit = defineEmits(['add-event']);

const weekdays = ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'];

const cells = computed(() => {
    const arr = [];
    for (let i = 0; i < props.startWeekday; i++) arr.push(null);
    for (let d = 1; d <= props.daysInMonth; d++) arr.push(d);
    return arr;
});

const pad = (n) => String(n).padStart(2, '0');
const onClick = (d) => {
    if (props.clickable && d && props.year) {
        emit('add-event', `${props.year}-${pad(props.month)}-${pad(d)}`);
    }
};
</script>

<template>
    <div>
        <div class="mb-2 text-center text-sm font-semibold capitalize text-slate-700">{{ monthLabel }}</div>
        <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-medium text-slate-400">
            <div v-for="w in weekdays" :key="w">{{ w }}</div>
        </div>
        <div class="mt-1 grid grid-cols-7 gap-1">
            <button
                v-for="(d, i) in cells"
                :key="i"
                type="button"
                :disabled="!d || !clickable"
                class="group relative flex h-7 items-center justify-center rounded-lg text-xs transition"
                :class="[
                    d === today ? 'bg-pjs-blue font-semibold text-white' : d ? 'text-slate-600 hover:bg-pjs-blue/10' : 'cursor-default',
                    d && clickable ? 'cursor-pointer' : '',
                ]"
                :title="d && clickable ? 'เพิ่มประชาสัมพันธ์วันนี้' : ''"
                @click="onClick(d)"
            >
                <template v-if="d">
                    <span class="group-hover:opacity-0">{{ d }}</span>
                    <i v-if="clickable" class="bi bi-plus-lg absolute opacity-0 group-hover:opacity-100" :class="d === today ? 'text-white' : 'text-pjs-blue'"></i>
                    <span v-if="events[d]" class="absolute bottom-0.5 h-1 w-1 rounded-full" :class="d === today ? 'bg-white' : 'bg-pjs-blue'"></span>
                </template>
            </button>
        </div>
        <p class="mt-2 flex items-center justify-center gap-1.5 text-[10px] text-slate-400">
            <span class="h-1.5 w-1.5 rounded-full bg-pjs-blue"></span> มีประชาสัมพันธ์ · คลิกวันเพื่อเพิ่ม
        </p>
    </div>
</template>
