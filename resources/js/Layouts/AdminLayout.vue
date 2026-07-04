<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import LoadingIndicator from '@/Components/Admin/LoadingIndicator.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash || {});

const mobileOpen = ref(false);
const openGroup = ref(null);

// เรียงตามลำดับหน้า frontend; เมนูที่ไม่ใช่หน้า frontend รวมไว้ใน "ตั้งค่าระบบ"
const nav = [
    { label: 'แดชบอร์ด', name: 'admin.dashboard', icon: 'bi bi-grid-1x2' },
    { label: 'แบนเนอร์', name: 'admin.banners.index', icon: 'bi bi-image' },
    { label: 'เกี่ยวกับเรา', name: 'admin.about.edit', icon: 'bi bi-info-circle' },
    { label: 'บริการ', name: 'admin.services.index', icon: 'bi bi-briefcase' },
    { label: 'บุคลากร', name: 'admin.team-members.index', icon: 'bi bi-people' },
    { label: 'ข่าวสาร', name: 'admin.news.index', icon: 'bi bi-newspaper' },
    { label: 'ประชาสัมพันธ์', name: 'admin.announcements.index', icon: 'bi bi-megaphone' },
    { label: 'คดีตัวอย่าง', name: 'admin.case-studies.index', icon: 'bi bi-bank' },
    { label: 'ดาวน์โหลด', name: 'admin.documents.index', icon: 'bi bi-cloud-arrow-down' },
    { label: 'ช่องทางติดต่อ', name: 'admin.contact-channels.index', icon: 'bi bi-telephone' },
    { label: 'ตั้งค่าระบบ', icon: 'bi bi-gear', items: [
        { label: 'กล่องข้อความ', name: 'admin.contacts.index', icon: 'bi bi-envelope' },
        { label: 'ตั้งค่าเว็บไซต์', name: 'admin.settings.edit', icon: 'bi bi-sliders' },
        { label: 'ผู้ใช้ระบบ', name: 'admin.users.index', icon: 'bi bi-shield-check', superAdmin: true },
    ] },
];

const visibleNav = computed(() =>
    nav
        .map((g) => (g.items ? { ...g, items: g.items.filter((i) => !i.superAdmin || user.value?.role === 'super_admin') } : g))
        .filter((g) => !g.items || g.items.length),
);

const hasRoute = (name) => name && route().has(name);
const isActive = (name) => name && (route().current(name) || route().current(name.replace(/\.index$/, '') + '.*'));
const groupActive = (g) => (g.items ? g.items.some((i) => isActive(i.name)) : isActive(g.name));

const toggleGroup = (label) => (openGroup.value = openGroup.value === label ? null : label);
const closeMenus = () => { openGroup.value = null; mobileOpen.value = false; };

const logout = () => router.post(route('logout'));
</script>

<template>
    <div class="min-h-screen bg-pjs-bg text-slate-700">
        <LoadingIndicator />

        <!-- Top bar -->
        <header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/85 backdrop-blur">
            <div class="mx-auto flex h-14 max-w-7xl items-center gap-3 px-4">
                <!-- Brand -->
                <Link :href="route('admin.dashboard')" class="flex items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-pjs-blue text-white"><i class="bi bi-briefcase text-sm"></i></span>
                    <span class="text-sm font-bold text-slate-800">PJS Admin</span>
                </Link>

                <!-- Desktop tabs -->
                <nav class="ml-2 hidden min-w-0 flex-1 items-center gap-0.5 overflow-x-auto lg:flex [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <template v-for="g in visibleNav" :key="g.label">
                        <!-- single -->
                        <template v-if="!g.items">
                            <Link
                                v-if="hasRoute(g.name)"
                                :href="route(g.name)"
                                class="flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1.5 text-xs transition"
                                :class="groupActive(g) ? 'bg-pjs-blue text-white' : 'text-slate-500 hover:bg-slate-100'"
                            >
                                <i :class="g.icon" class="text-xs"></i>{{ g.label }}
                            </Link>
                            <span v-else class="flex shrink-0 cursor-default items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1.5 text-xs text-slate-300" title="เร็วๆนี้">
                                <i :class="g.icon" class="text-xs"></i>{{ g.label }}
                            </span>
                        </template>
                        <!-- dropdown -->
                        <div v-else class="relative">
                            <button
                                class="flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1.5 text-xs transition"
                                :class="groupActive(g) || openGroup === g.label ? 'bg-pjs-blue text-white' : 'text-slate-500 hover:bg-slate-100'"
                                @click="toggleGroup(g.label)"
                            >
                                <i :class="g.icon" class="text-xs"></i>{{ g.label }}
                                <i class="bi bi-chevron-down text-[10px]"></i>
                            </button>
                            <Transition enter-active-class="transition duration-100" enter-from-class="opacity-0 -translate-y-1" leave-active-class="transition duration-100" leave-to-class="opacity-0 -translate-y-1">
                                <div v-if="openGroup === g.label" class="absolute left-0 z-50 mt-1.5 w-56 rounded-2xl border border-slate-100 bg-white p-1.5 shadow-soft">
                                    <template v-for="item in g.items" :key="item.name">
                                        <Link
                                            v-if="hasRoute(item.name)"
                                            :href="route(item.name)"
                                            class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm transition"
                                            :class="isActive(item.name) ? 'bg-pjs-blue/10 font-medium text-pjs-blue' : 'text-slate-600 hover:bg-slate-50'"
                                            @click="closeMenus"
                                        >
                                            <i :class="item.icon" class="text-pjs-blue/70"></i>{{ item.label }}
                                        </Link>
                                        <div v-else class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm text-slate-300">
                                            <i :class="item.icon"></i>{{ item.label }}
                                            <span class="ml-auto text-[9px]">เร็วๆนี้</span>
                                        </div>
                                    </template>
                                </div>
                            </Transition>
                        </div>
                    </template>
                </nav>

                <!-- Right -->
                <div class="ml-auto flex items-center gap-2">
                    <Link :href="route('profile.edit')" class="hidden items-center gap-2 rounded-full py-0.5 pl-0.5 pr-3 hover:bg-slate-100 sm:flex">
                        <img v-if="user?.avatar" :src="user.avatar" class="h-8 w-8 rounded-full object-cover" />
                        <span v-else class="flex h-8 w-8 items-center justify-center rounded-full bg-pjs-blue/10 text-pjs-blue"><i class="bi bi-person text-sm"></i></span>
                        <span class="text-sm text-slate-600">{{ user?.name }}</span>
                    </Link>
                    <button class="flex h-9 w-9 items-center justify-center rounded-full text-slate-400 hover:bg-slate-100" title="ออกจากระบบ" @click="logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                    <button class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 lg:hidden" @click="mobileOpen = !mobileOpen">
                        <i class="bi bi-list text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- click-away backdrop for dropdowns -->
            <div v-if="openGroup" class="fixed inset-0 z-30" @click="openGroup = null"></div>

            <!-- Mobile nav -->
            <Transition enter-active-class="transition" enter-from-class="opacity-0" leave-active-class="transition" leave-to-class="opacity-0">
                <nav v-if="mobileOpen" class="border-t border-slate-100 bg-white px-4 py-3 lg:hidden">
                    <div v-for="g in visibleNav" :key="g.label" class="mb-2">
                        <p class="px-2 pb-1 text-[10px] font-semibold uppercase tracking-wider text-slate-400">{{ g.label }}</p>
                        <template v-for="item in (g.items || [g])" :key="item.name">
                            <Link v-if="hasRoute(item.name)" :href="route(item.name)" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm text-slate-600 hover:bg-slate-50" @click="closeMenus">
                                <i :class="item.icon" class="text-pjs-blue/70"></i>{{ item.label }}
                            </Link>
                        </template>
                    </div>
                </nav>
            </Transition>
        </header>

        <!-- Flash -->
        <div v-if="flash.success || flash.error" class="mx-auto max-w-7xl px-4 pt-4">
            <div v-if="flash.success" class="flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-2.5 text-sm text-green-800"><i class="bi bi-check-circle"></i>{{ flash.success }}</div>
            <div v-if="flash.error" class="flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm text-red-800"><i class="bi bi-x-circle"></i>{{ flash.error }}</div>
        </div>

        <!-- Page -->
        <main class="mx-auto max-w-7xl px-4 py-5">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold text-slate-800"><slot name="title">หลังบ้าน</slot></h1>
            </div>
            <slot />
        </main>
    </div>
</template>
