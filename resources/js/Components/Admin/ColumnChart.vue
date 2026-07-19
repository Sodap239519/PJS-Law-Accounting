<script setup>
import { computed } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
    labels: { type: Array, default: () => [] },
    data: { type: Array, default: () => [] },
    name: { type: String, default: 'ผู้เข้าชม' },
    color: { type: String, default: '#2563eb' },
});

const chartSeries = computed(() => [{ name: props.name, data: props.data }]);

// column + data labels — apexcharts.com/vue-chart-demos/column-charts/column-with-data-labels
const chartOptions = computed(() => ({
    chart: {
        type: 'bar',
        height: 190,
        fontFamily: 'Prompt, sans-serif',
        toolbar: { show: false },
        animations: { easing: 'easeinout', speed: 600 },
    },
    colors: [props.color],
    plotOptions: {
        bar: {
            borderRadius: 6,
            columnWidth: '55%',
            dataLabels: { position: 'top' },
        },
    },
    dataLabels: {
        enabled: true,
        formatter: (val) => (val ? val : ''),
        offsetY: -18,
        style: { fontSize: '10px', colors: ['#64748b'] },
    },
    grid: { borderColor: '#eef2f7', xaxis: { lines: { show: false } }, padding: { left: 4, right: 8, top: 0 } },
    xaxis: {
        categories: props.labels,
        labels: { style: { fontSize: '10px', colors: '#94a3b8' } },
        axisBorder: { show: false },
        axisTicks: { show: false },
    },
    yaxis: { labels: { show: false } },
    legend: { show: false },
    tooltip: { theme: 'light' },
}));
</script>

<template>
    <VueApexCharts type="bar" height="190" :options="chartOptions" :series="chartSeries" />
</template>
