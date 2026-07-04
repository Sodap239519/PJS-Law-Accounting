<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash || {});

const sidebarOpen = ref(false);

const menu = [
    { section: 'ภาพรวม', items: [
        { label: 'แดชบอร์ด', name: 'admin.dashboard', icon: '📊' },
    ] },
    { section: 'เนื้อหาเว็บ', items: [
        { label: 'แบนเนอร์', name: 'admin.banners.index', icon: '🖼️' },
        { label: 'เกี่ยวกับเรา', name: 'admin.about.edit', icon: 'ℹ️' },
        { label: 'บริการ', name: 'admin.services.index', icon: '🧰' },
    ] },
    { section: 'ข่าว & สื่อ', items: [
        { label: 'ข่าวสารและกิจกรรม', name: 'admin.news.index', icon: '📰' },
        { label: 'ประชาสัมพันธ์', name: 'admin.announcements.index', icon: '📣' },
        { label: 'คดีตัวอย่าง', name: 'admin.case-studies.index', icon: '⚖️' },
    ] },
    { section: 'ข้อมูลองค์กร', items: [
        { label: 'บุคลากร', name: 'admin.team-members.index', icon: '👥' },
        { label: 'เอกสารดาวน์โหลด', name: 'admin.documents.index', icon: '📎' },
    ] },
    { section: 'ติดต่อ', items: [
        { label: 'ช่องทางติดต่อ', name: 'admin.contact-channels.index', icon: '☎️' },
        { label: 'กล่องข้อความ', name: 'admin.contacts.index', icon: '✉️' },
    ] },
    { section: 'ระบบ', items: [
        { label: 'ตั้งค่าเว็บไซต์', name: 'admin.settings.edit', icon: '⚙️' },
        { label: 'ผู้ใช้ระบบ', name: 'admin.users.index', icon: '🔐', superAdmin: true },
    ] },
];

const visibleMenu = computed(() =>
    menu
        .map((g) => ({
            ...g,
            items: g.items.filter((i) => !i.superAdmin || user.value?.role === 'super_admin'),
        }))
        .filter((g) => g.items.length),
);

const hasRoute = (name) => route().has(name);
const isActive = (name) => route().current(name) || route().current(name.replace(/\.index$/, '') + '.*');

const logout = () => router.post(route('logout'));
</script>

<template>
    <div class="min-h-screen bg-gray-100 text-gray-800">
        <!-- Mobile overlay -->
        <div
            v-if="sidebarOpen"
            class="fixed inset-0 z-30 bg-black/40 lg:hidden"
            @click="sidebarOpen = false"
        />

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 transform overflow-y-auto bg-pjs-blue text-white transition-transform duration-200 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex h-16 items-center gap-2 border-b border-white/10 px-5">
                <span class="text-lg font-bold tracking-wide">PJS Admin</span>
            </div>
            <nav class="px-3 py-4">
                <div v-for="group in visibleMenu" :key="group.section" class="mb-5">
                    <p class="px-3 pb-1 text-xs font-semibold uppercase tracking-wider text-white/40">
                        {{ group.section }}
                    </p>
                    <template v-for="item in group.items" :key="item.name">
                        <Link
                            v-if="hasRoute(item.name)"
                            :href="route(item.name)"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition hover:bg-white/10"
                            :class="isActive(item.name) ? 'bg-white/15 font-semibold' : 'text-white/85'"
                            @click="sidebarOpen = false"
                        >
                            <span>{{ item.icon }}</span>
                            <span>{{ item.label }}</span>
                        </Link>
                        <div
                            v-else
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-white/35"
                            title="เร็วๆ นี้"
                        >
                            <span>{{ item.icon }}</span>
                            <span>{{ item.label }}</span>
                            <span class="ml-auto rounded bg-white/10 px-1.5 py-0.5 text-[10px]">เร็วๆนี้</span>
                        </div>
                    </template>
                </div>
            </nav>
        </aside>

        <!-- Main -->
        <div class="lg:pl-64">
            <!-- Topbar -->
            <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b bg-white px-4 shadow-sm">
                <button class="rounded p-2 hover:bg-gray-100 lg:hidden" @click="sidebarOpen = true">
                    ☰
                </button>
                <h1 class="text-base font-semibold text-gray-700">
                    <slot name="title">หลังบ้าน</slot>
                </h1>
                <div class="ml-auto flex items-center gap-3">
                    <Link
                        :href="route('profile.edit')"
                        class="hidden text-sm text-gray-600 hover:text-pjs-blue sm:block"
                    >
                        {{ user?.name }}
                        <span class="ml-1 rounded bg-pjs-gold/20 px-1.5 py-0.5 text-xs text-pjs-gold-dark">
                            {{ user?.role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                        </span>
                    </Link>
                    <button
                        class="rounded-lg border border-gray-200 px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-50"
                        @click="logout"
                    >
                        ออกจากระบบ
                    </button>
                </div>
            </header>

            <!-- Flash -->
            <div v-if="flash.success || flash.error" class="px-4 pt-4">
                <div
                    v-if="flash.success"
                    class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
                >
                    {{ flash.success }}
                </div>
                <div
                    v-if="flash.error"
                    class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                >
                    {{ flash.error }}
                </div>
            </div>

            <!-- Page content -->
            <main class="p-4 sm:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
