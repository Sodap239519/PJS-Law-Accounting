<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: { type: Object, default: () => ({}) },
});

const cards = computed(() => [
    { label: 'ข่าวสาร/กิจกรรม', value: props.stats.news ?? 0, route: 'admin.news.index', icon: '📰' },
    { label: 'ประชาสัมพันธ์', value: props.stats.announcements ?? 0, route: 'admin.announcements.index', icon: '📣' },
    { label: 'คดีตัวอย่าง', value: props.stats.caseStudies ?? 0, route: 'admin.case-studies.index', icon: '⚖️' },
    { label: 'บริการ', value: props.stats.services ?? 0, route: 'admin.services.index', icon: '🧰' },
    { label: 'เอกสารดาวน์โหลด', value: props.stats.documents ?? 0, route: 'admin.documents.index', icon: '📎' },
    { label: 'บุคลากร', value: props.stats.team ?? 0, route: 'admin.team-members.index', icon: '👥' },
    { label: 'แบนเนอร์', value: props.stats.banners ?? 0, route: 'admin.banners.index', icon: '🖼️' },
    { label: 'ข้อความยังไม่อ่าน', value: props.stats.unreadContacts ?? 0, route: 'admin.contacts.index', icon: '✉️', highlight: true },
]);

const hasRoute = (name) => route().has(name);
</script>

<template>
    <Head title="แดชบอร์ด" />
    <AdminLayout>
        <template #title>แดชบอร์ด</template>

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">ยินดีต้อนรับสู่หลังบ้าน PJS</h2>
            <p class="text-sm text-gray-500">ภาพรวมเนื้อหาบนเว็บไซต์</p>
        </div>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-4">
            <component
                :is="hasRoute(card.route) ? Link : 'div'"
                v-for="card in cards"
                :key="card.label"
                :href="hasRoute(card.route) ? route(card.route) : undefined"
                class="rounded-xl border bg-white p-5 shadow-sm transition"
                :class="[
                    hasRoute(card.route) ? 'hover:shadow-md hover:-translate-y-0.5' : 'opacity-90',
                    card.highlight && card.value > 0 ? 'ring-2 ring-pjs-gold' : '',
                ]"
            >
                <div class="flex items-center justify-between">
                    <span class="text-2xl">{{ card.icon }}</span>
                    <span class="text-3xl font-bold text-pjs-blue">{{ card.value }}</span>
                </div>
                <p class="mt-2 text-sm font-medium text-gray-600">{{ card.label }}</p>
            </component>
        </div>

        <div class="mt-8 rounded-xl border bg-white p-6 shadow-sm">
            <h3 class="mb-2 font-semibold text-gray-800">เริ่มต้นใช้งาน</h3>
            <p class="text-sm text-gray-500">
                เมนูด้านซ้ายจะเปิดใช้งานทีละส่วนตามที่พัฒนาเสร็จ ระบบจัดการเนื้อหาแบบเต็มกำลังทยอยเพิ่มเข้ามา
            </p>
        </div>
    </AdminLayout>
</template>
