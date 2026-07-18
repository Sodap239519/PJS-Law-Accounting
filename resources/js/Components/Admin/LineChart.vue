<script setup>
import { computed } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
    labels: { type: Array, default: () => [] },
    // [{ name, color, data: [] }]
    series: { type: Array, default: () => [] },
});

const chartSeries = computed(() => props.series.map((s) => ({ name: s.name, data: s.data })));

// area-spline (เส้นโค้งลื่น + gradient) แบบ apexcharts.com/vue-chart-demos/area-charts/area-spline
const chartOptions = computed(() => ({
    chart: {
        type: 'area',
        height: 190,
        fontFamily: 'Prompt, sans-serif',
        toolbar: { show: false },
        zoom: { enabled: false },
        animations: { easing: 'easeinout', speed: 600 },
    },
    colors: props.series.map((s) => s.color),
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2.5 },
    fill: {
        type: 'gradient',
        gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.03, stops: [0, 95] },
    },
    markers: { size: 0, hover: { size: 4 } },
    grid: { borderColor: '#eef2f7', strokeDashArray: 0, xaxis: { lines: { show: false } }, padding: { left: 4, right: 8, top: 0 } },
    xaxis: {
        categories: props.labels,
        tickAmount: 6,
        labels: { style: { fontSize: '10px', colors: '#94a3b8' } },
        axisBorder: { show: false },
        axisTicks: { show: false },
    },
    yaxis: { labels: { show: false } },
    legend: { show: true, position: 'top', horizontalAlign: 'left', fontSize: '11px', labels: { colors: '#64748b' }, markers: { width: 8, height: 8, radius: 8 }, itemMargin: { horizontal: 8 } },
    tooltip: { theme: 'light', x: { show: true } },
}));
</script>

<template>
    <VueApexCharts type="area" height="190" :options="chartOptions" :series="chartSeries" />
</template>
