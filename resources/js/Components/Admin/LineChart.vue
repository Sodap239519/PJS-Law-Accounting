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
const padT = 10;
const padB = 20;
const innerW = W - padL - padR;
const innerH = H - padT - padB;

const max = computed(() => Math.max(1, ...props.series.flatMap((s) => s.data)));
const n = computed(() => props.labels.length);

const xAt = (i) => (n.value > 1 ? padL + (i / (n.value - 1)) * innerW : padL + innerW / 2);
const yAt = (v) => padT + innerH - (v / max.value) * innerH;

// เส้นโค้งลื่น (Catmull-Rom → Bézier) แบบ area-spline
const smoothLine = (data) => {
    const p = data.map((v, i) => [xAt(i), yAt(v)]);
    if (!p.length) return '';
    if (p.length === 1) return `M ${p[0][0]},${p[0][1]}`;
    let d = `M ${p[0][0]},${p[0][1]}`;
    for (let i = 0; i < p.length - 1; i++) {
        const p0 = p[i - 1] || p[i];
        const p1 = p[i];
        const p2 = p[i + 1];
        const p3 = p[i + 2] || p2;
        const c1x = p1[0] + (p2[0] - p0[0]) / 6;
        const c1y = p1[1] + (p2[1] - p0[1]) / 6;
        const c2x = p2[0] - (p3[0] - p1[0]) / 6;
        const c2y = p2[1] - (p3[1] - p1[1]) / 6;
        d += ` C ${c1x},${c1y} ${c2x},${c2y} ${p2[0]},${p2[1]}`;
    }
    return d;
};
const smoothArea = (data) => {
    const line = smoothLine(data);
    if (!line) return '';
    return `${line} L ${xAt(data.length - 1)},${padT + innerH} L ${xAt(0)},${padT + innerH} Z`;
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
            <defs>
                <linearGradient v-for="(s, si) in series" :id="'grad' + si" :key="'g' + si" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" :stop-color="s.color" stop-opacity="0.35" />
                    <stop offset="100%" :stop-color="s.color" stop-opacity="0.02" />
                </linearGradient>
            </defs>

            <line v-for="(gy, i) in gridY" :key="i" :x1="padL" :x2="W - padR" :y1="gy" :y2="gy" stroke="#eef2f7" stroke-width="1" />

            <template v-for="(s, si) in series" :key="s.name">
                <path :d="smoothArea(s.data)" :fill="'url(#grad' + si + ')'" />
                <path :d="smoothLine(s.data)" fill="none" :stroke="s.color" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                <circle v-for="(v, i) in s.data" :key="i" :cx="xAt(i)" :cy="yAt(v)" r="2" :fill="'#fff'" :stroke="s.color" stroke-width="1.5" />
            </template>

            <text v-for="i in tickIdx" :key="'t' + i" :x="xAt(i)" :y="H - 6" text-anchor="middle" fill="#94a3b8" style="font-size: 9px">{{ labels[i] }}</text>
        </svg>
    </div>
</template>
