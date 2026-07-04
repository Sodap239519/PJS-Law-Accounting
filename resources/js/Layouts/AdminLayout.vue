<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash || {});

const sidebarOpen = ref(false);

const menu = [
    { section: 'ภาพรวม', items: [
        { label: 'แดชบอร์ด', name: 'admin.dashboard', icon: 'bi bi-grid-1x2' },
    ] },
    { section: 'เนื้อหาเว็บ', items: [
        { label: 'แบนเนอร์', name: 'admin.banners.index', icon: 'bi bi-image' },
        { label: 'เกี่ยวกับเรา', name: 'admin.about.edit', icon: 'bi bi-info-circle' },
        { label: 'บริการ', name: 'admin.services.index', icon: 'bi bi-briefcase' },
    ] },
    { section: 'ข่าว & สื่อ', items: [
        { label: 'ข่าวสารและกิจกรรม', name: 'admin.news.index', icon: 'bi bi-newspaper' },
        { label: 'ประชาสัมพันธ์', name: 'admin.announcements.index', icon: 'bi bi-megaphone' },
        { label: 'คดีตัวอย่าง', name: 'admin.case-studies.index', icon: 'bi bi-bank' },
    ] },
    { section: 'ข้อมูลองค์กร', items: [
        { label: 'บุคลากร', name: 'admin.team-members.index', icon: 'bi bi-people' },
        { label: 'เอกสารดาวน์โหลด', name: 'admin.documents.index', icon: 'bi bi-cloud-arrow-down' },
    ] },
    { section: 'ติดต่อ', items: [
        { label: 'ช่องทางติดต่อ', name: 'admin.contact-channels.index', icon: 'bi bi-telephone' },
        { label: 'กล่องข้อความ', name: 'admin.contacts.index', icon: 'bi bi-envelope' },
    ] },
    { section: 'ระบบ', items: [
        { label: 'ตั้งค่าเว็บไซต์', name: 'admin.settings.edit', icon: 'bi bi-gear' },
        { label: 'ผู้ใช้ระบบ', name: 'admin.users.index', icon: 'bi bi-shield-check', superAdmin: true },
    ] },
];

const visibleMenu = computed(() =>
    menu
        .map((g) => ({ ...g, items: g.items.filter((i) => !i.superAdmin || user.value?.role === 'super_admin') }))
        .filter((g) => g.items.length),
);

const hasRoute = (name) => route().has(name);
const isActive = (name) => route().current(name) || route().current(name.replace(/\.index$/, '') + '.*');

const logout = () => router.post(route('logout'));
</script>

<template>
    <div class="min-h-screen bg-pjs-bg text-slate-700">
        <!-- Mobile overlay -->
        <div v-if="sidebarOpen" class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" />

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 flex w-64 transform flex-col overflow-y-auto bg-pjs-navy text-white transition-transform duration-200 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex h-16 items-center gap-3 px-5">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-pjs-blue text-white">
                    <i class="bi bi-briefcase text-base leading-none"></i>
                </div>
                <div class="leading-tight">
                    <p class="text-sm font-bold tracking-wide">PJS Admin</p>
                    <p class="text-[10px] text-blue-200/60">ระบบจัดการเว็บไซต์</p>
                </div>
            </div>

            <nav class="flex-1 px-3 py-3">
                <div v-for="group in visibleMenu" :key="group.section" class="mb-4">
                    <p class="px-3 pb-1 text-[10px] font-semibold uppercase tracking-widest text-blue-200/40">{{ group.section }}</p>
                    <template v-for="item in group.items" :key="item.name">
                        <Link
                            v-if="hasRoute(item.name)"
                            :href="route(item.name)"
                            class="mb-0.5 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition"
                            :class="isActive(item.name) ? 'bg-pjs-blue text-white shadow-lg shadow-pjs-blue/30' : 'text-blue-100/80 hover:bg-white/5'"
                            @click="sidebarOpen = false"
                        >
                            <i :class="item.icon" class="text-base leading-none"></i>
                            <span>{{ item.label }}</span>
                        </Link>
                        <div v-else class="mb-0.5 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-blue-200/30">
                            <i :class="item.icon" class="text-base leading-none"></i>
                            <span>{{ item.label }}</span>
                            <span class="ml-auto rounded-md bg-white/5 px-1.5 py-0.5 text-[9px]">เร็วๆนี้</span>
                        </div>
                    </template>
                </div>
            </nav>
        </aside>

        <!-- Main -->
        <div class="lg:pl-64">
            <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-slate-200/70 bg-white/80 px-4 backdrop-blur">
                <button class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 lg:hidden" @click="sidebarOpen = true">
                    <i class="bi bi-list leading-none"></i>
                </button>
                <h1 class="text-base font-semibold text-slate-800"><slot name="title">หลังบ้าน</slot></h1>
                <div class="ml-auto flex items-center gap-2">
                    <Link :href="route('profile.edit')" class="hidden items-center gap-2 rounded-full py-1 pl-1 pr-3 text-sm hover:bg-slate-100 sm:flex">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-pjs-blue/10 text-pjs-blue">
                            <i class="bi bi-person text-sm leading-none"></i>
                        </span>
                        <span class="text-slate-600">{{ user?.name }}</span>
                        <span class="rounded-full bg-pjs-blue/10 px-2 py-0.5 text-[11px] font-medium text-pjs-blue-dark">
                            {{ user?.role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                        </span>
                    </Link>
                    <button class="flex h-9 items-center gap-2 rounded-lg border border-slate-200 px-3 text-sm text-slate-500 hover:bg-slate-50" @click="logout">
                        <i class="bi bi-box-arrow-right leading-none"></i>
                        <span class="hidden sm:inline">ออกจากระบบ</span>
                    </button>
                </div>
            </header>

            <div v-if="flash.success || flash.error" class="px-4 pt-4 sm:px-6">
                <div v-if="flash.success" class="flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <i class="bi bi-check-circle leading-none"></i>{{ flash.success }}
                </div>
                <div v-if="flash.error" class="flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <i class="bi bi-x-circle leading-none"></i>{{ flash.error }}
                </div>
            </div>

            <main class="p-4 sm:p-6"><slot /></main>
        </div>
    </div>
</template>
