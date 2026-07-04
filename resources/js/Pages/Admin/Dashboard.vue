<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    stats: { type: Object, default: () => ({}) },
});

const cards = computed(() => [
    { label: 'ข่าวสาร/กิจกรรม', value: props.stats.news ?? 0, route: 'admin.news.index', icon: 'fi fi-rr-document' },
    { label: 'ประชาสัมพันธ์', value: props.stats.announcements ?? 0, route: 'admin.announcements.index', icon: 'fi fi-rr-megaphone' },
    { label: 'คดีตัวอย่าง', value: props.stats.caseStudies ?? 0, route: 'admin.case-studies.index', icon: 'fi fi-rr-gavel' },
    { label: 'บริการ', value: props.stats.services ?? 0, route: 'admin.services.index', icon: 'fi fi-rr-briefcase' },
    { label: 'เอกสารดาวน์โหลด', value: props.stats.documents ?? 0, route: 'admin.documents.index', icon: 'fi fi-rr-cloud-download-alt' },
    { label: 'บุคลากร', value: props.stats.team ?? 0, route: 'admin.team-members.index', icon: 'fi fi-rr-users' },
    { label: 'แบนเนอร์', value: props.stats.banners ?? 0, route: 'admin.banners.index', icon: 'fi fi-rr-picture' },
    { label: 'ข้อความยังไม่อ่าน', value: props.stats.unreadContacts ?? 0, route: 'admin.contacts.index', icon: 'fi fi-rr-envelope', highlight: true },
]);

const hasRoute = (name) => route().has(name);
</script>

<template>
    <Head title="แดชบอร์ด" />
    <AdminLayout>
        <template #title>แดชบอร์ด</template>

        <div class="mb-6 rounded-2xl bg-gradient-to-r from-pjs-navy to-pjs-blue p-6 text-white shadow-soft">
            <h2 class="text-xl font-bold">ยินดีต้อนรับสู่หลังบ้าน PJS 👋</h2>
            <p class="mt-1 text-sm text-blue-100/80">ภาพรวมเนื้อหาบนเว็บไซต์ของคุณ</p>
        </div>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-4">
            <component
                :is="hasRoute(card.route) ? Link : 'div'"
                v-for="card in cards"
                :key="card.label"
                :href="hasRoute(card.route) ? route(card.route) : undefined"
                class="group rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition"
                :class="[
                    hasRoute(card.route) ? 'hover:-translate-y-0.5 hover:shadow-soft' : 'opacity-95',
                    card.highlight && card.value > 0 ? 'ring-2 ring-pjs-blue/40' : '',
                ]"
            >
                <div class="flex items-center justify-between">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-pjs-blue/10 text-pjs-blue transition group-hover:bg-pjs-blue group-hover:text-white">
                        <i :class="card.icon" class="text-lg leading-none"></i>
                    </span>
                    <span class="text-3xl font-bold text-pjs-navy">{{ card.value }}</span>
                </div>
                <p class="mt-3 text-sm font-medium text-slate-500">{{ card.label }}</p>
            </component>
        </div>

        <div class="mt-6 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            <h3 class="mb-1 font-semibold text-slate-800">เริ่มต้นใช้งาน</h3>
            <p class="text-sm text-slate-500">
                เมนูด้านซ้ายจะเปิดใช้งานทีละส่วนตามที่พัฒนาเสร็จ — ระบบจัดการเนื้อหาแบบเต็มกำลังทยอยเพิ่มเข้ามา
            </p>
        </div>
    </AdminLayout>
</template>
