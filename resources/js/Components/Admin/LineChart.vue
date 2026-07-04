<script setup>
import { computed } from 'vue';

const props = defineProps({
    labels: { type: Array, default: () => [] },
    // [{ name, color, data: [] }]
    series: { type: Array, default: () => [] },
});

const W = 340;
const H = 150;
const padL = 6;
const padR = 6;
const padT = 8;
const padB = 20;
const innerW = W - padL - padR;
const innerH = H - padT - padB;

const max = computed(() => Math.max(1, ...props.series.flatMap((s) => s.data)));
const n = computed(() => props.labels.length);

const xAt = (i) => (n.value > 1 ? padL + (i / (n.value - 1)) * innerW : padL + innerW / 2);
const yAt = (v) => padT + innerH - (v / max.value) * innerH;

const linePath = (data) => data.map((v, i) => `${xAt(i)},${yAt(v)}`).join(' ');
const areaPath = (data) => {
    if (!data.length) return '';
    const top = data.map((v, i) => `${xAt(i)},${yAt(v)}`).join(' L ');
    return `M ${xAt(0)},${padT + innerH} L ${top} L ${xAt(data.length - 1)},${padT + innerH} Z`;
};

const gridY = computed(() => [0, 0.5, 1].map((f) => padT + innerH - f * innerH));
const tickIdx = computed(() => {
    const step = Math.max(1, Math.ceil(n.value / 5));
    return props.labels.map((_, i) => i).filter((i) => i % step === 0 || i === n.value - 1);
});
</script>

<template>
    <div>
        <div class="mb-1 flex flex-wrap gap-3">
            <span v-for="s in series" :key="s.name" class="flex items-center gap-1.5 text-[11px] text-slate-500">
                <span class="h-2 w-2 rounded-full" :style="{ background: s.color }"></span>{{ s.name }}
            </span>
        </div>
        <svg :viewBox="`0 0 ${W} ${H}`" class="w-full" preserveAspectRatio="none" style="height: 150px">
            <line v-for="(gy, i) in gridY" :key="i" :x1="padL" :x2="W - padR" :y1="gy" :y2="gy" stroke="#eef2f7" stroke-width="1" />
            <template v-for="s in series" :key="s.name">
                <path :d="areaPath(s.data)" :fill="s.color" fill-opacity="0.08" />
                <polyline :points="linePath(s.data)" fill="none" :stroke="s.color" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <circle v-for="(v, i) in s.data" :key="i" :cx="xAt(i)" :cy="yAt(v)" r="2.5" :fill="s.color" />
            </template>
            <text v-for="i in tickIdx" :key="'t' + i" :x="xAt(i)" :y="H - 6" text-anchor="middle" fill="#94a3b8" style="font-size: 9px">{{ labels[i] }}</text>
        </svg>
    </div>
</template>
