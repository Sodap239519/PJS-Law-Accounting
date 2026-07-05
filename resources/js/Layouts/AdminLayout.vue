<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import LoadingIndicator from '@/Components/Admin/LoadingIndicator.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash || {});
const unread = computed(() => page.props.unreadMessages || 0);

const mobileOpen = ref(false);
const openGroup = ref(null);
const profileOpen = ref(false);

// เรียงตามลำดับหน้า frontend; เมนูระบบรวมใน "ตั้งค่าระบบ"
const nav = [
    { label: 'แดชบอร์ด', name: 'admin.dashboard', icon: 'bi bi-grid-1x2' },
    { label: 'เกี่ยวกับเรา', name: 'admin.about.edit', icon: 'bi bi-info-circle' },
    { label: 'บริการของเรา', name: 'admin.services.index', icon: 'bi bi-briefcase' },
    { label: 'ทีมงาน', name: 'admin.team-members.index', icon: 'bi bi-people' },
    { label: 'ข่าวสาร', icon: 'bi bi-newspaper', items: [
        { label: 'ข่าวสารและกิจกรรม', name: 'admin.news.index', icon: 'bi bi-newspaper' },
        { label: 'ประชาสัมพันธ์', name: 'admin.announcements.index', icon: 'bi bi-megaphone' },
    ] },
    { label: 'คดีตัวอย่าง', name: 'admin.case-studies.index', icon: 'bi bi-bank' },
    { label: 'ช่องทางติดต่อ', name: 'admin.contact-channels.index', icon: 'bi bi-telephone' },
    { label: 'ตั้งค่าระบบ', icon: 'bi bi-gear', align: 'right', items: [
        { label: 'แบนเนอร์', name: 'admin.banners.index', icon: 'bi bi-image' },
        { label: 'เอกสารดาวน์โหลด', name: 'admin.documents.index', icon: 'bi bi-cloud-arrow-down' },
        { label: 'กล่องข้อความ', name: 'admin.contacts.index', icon: 'bi bi-envelope' },
        { label: 'จัดการเมนู', name: 'admin.menus.index', icon: 'bi bi-list-nested', superAdmin: true },
        { label: 'จัดการโลโก้/ชื่อเว็บ', name: 'admin.settings.edit', icon: 'bi bi-sliders' },
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

const logout = () => router.post(route('logout'));

// ปิดเมนู/ดรอปดาวน์ทุกครั้งที่เริ่มนำทาง (ไม่ต้องผูก @click ที่ทำให้ Link ถูก unmount ก่อนนำทาง)
let offStart = null;
onMounted(() => {
    offStart = router.on('start', () => {
        openGroup.value = null;
        profileOpen.value = false;
        mobileOpen.value = false;
    });
});
onUnmounted(() => offStart?.());

const currentYear = new Date().getFullYear();
</script>

<template>
    <div class="min-h-screen bg-pjs-bg text-slate-700">
        <LoadingIndicator />

        <!-- Floating pill header -->
        <header class="sticky top-0 z-40 px-3 pt-3">
            <div class="mx-auto flex h-14 max-w-6xl items-center gap-1 rounded-full border border-slate-200/70 bg-white/90 pl-4 pr-2 shadow-sm backdrop-blur">
                <!-- Brand -->
                <Link :href="route('admin.dashboard')" class="flex shrink-0 items-center gap-2">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-pjs-blue text-white"><i class="bi bi-briefcase text-sm"></i></span>
                    <span class="hidden text-sm font-bold text-slate-800 xl:block">PJS Admin</span>
                </Link>

                <!-- Tabs (centered) -->
                <nav class="mx-1 hidden flex-1 items-center justify-center gap-0.5 lg:flex">
                    <template v-for="g in visibleNav" :key="g.label">
                        <template v-if="!g.items">
                            <Link
                                v-if="hasRoute(g.name)"
                                :href="route(g.name)"
                                class="flex shrink-0 items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1.5 text-sm transition"
                                :class="groupActive(g) ? 'bg-pjs-blue text-white shadow' : 'text-slate-500 hover:bg-slate-100'"
                            >
                                <i :class="g.icon" class="text-xs"></i>{{ g.label }}
                            </Link>
                            <span v-else class="flex shrink-0 cursor-default items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1.5 text-sm text-slate-300" title="เร็วๆนี้">
                                <i :class="g.icon" class="text-xs"></i>{{ g.label }}
                            </span>
                        </template>
                        <div v-else class="relative shrink-0">
                            <button
                                class="flex items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1.5 text-sm transition"
                                :class="groupActive(g) || openGroup === g.label ? 'bg-pjs-blue text-white shadow' : 'text-slate-500 hover:bg-slate-100'"
                                @click="toggleGroup(g.label)"
                            >
                                <i :class="g.icon" class="text-xs"></i>{{ g.label }}
                                <i class="bi bi-chevron-down text-[9px]"></i>
                            </button>
                            <Transition enter-active-class="transition duration-100" enter-from-class="opacity-0 -translate-y-1" leave-active-class="transition duration-100" leave-to-class="opacity-0 -translate-y-1">
                                <div v-if="openGroup === g.label" class="absolute z-50 mt-2 w-60 rounded-2xl border border-slate-100 bg-white p-1.5 shadow-soft" :class="g.align === 'right' ? 'right-0' : 'left-0'">
                                    <template v-for="item in g.items" :key="item.name">
                                        <Link
                                            v-if="hasRoute(item.name)"
                                            :href="route(item.name)"
                                            class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm transition"
                                            :class="isActive(item.name) ? 'bg-pjs-blue/10 font-medium text-pjs-blue' : 'text-slate-600 hover:bg-slate-50'"
                                        >
                                            <i :class="item.icon" class="text-pjs-blue/70"></i>{{ item.label }}
                                        </Link>
                                        <div v-else class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm text-slate-300">
                                            <i :class="item.icon"></i>{{ item.label }}<span class="ml-auto text-[9px]">เร็วๆนี้</span>
                                        </div>
                                    </template>
                                </div>
                            </Transition>
                        </div>
                    </template>
                </nav>

                <!-- Right -->
                <div class="ml-auto flex shrink-0 items-center gap-1 lg:ml-0">
                    <!-- Messages -->
                    <component
                        :is="hasRoute('admin.contacts.index') ? Link : 'button'"
                        :href="hasRoute('admin.contacts.index') ? route('admin.contacts.index') : undefined"
                        class="relative flex h-9 w-9 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100"
                        title="กล่องข้อความ"
                    >
                        <i class="bi bi-envelope text-base"></i>
                        <span v-if="unread > 0" class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-red-500 px-1 text-[9px] font-bold text-white">{{ unread > 99 ? '99+' : unread }}</span>
                    </component>

                    <!-- Profile dropdown -->
                    <div class="relative">
                        <button class="flex h-9 w-9 items-center justify-center rounded-full transition hover:ring-2 hover:ring-pjs-blue/30" title="โปรไฟล์" @click="profileOpen = !profileOpen">
                            <img v-if="user?.avatar" :src="user.avatar" class="h-8 w-8 rounded-full object-cover" />
                            <span v-else class="flex h-8 w-8 items-center justify-center rounded-full bg-pjs-blue/10 text-pjs-blue"><i class="bi bi-person text-sm"></i></span>
                        </button>
                        <Transition enter-active-class="transition duration-100" enter-from-class="opacity-0 -translate-y-1" leave-active-class="transition duration-100" leave-to-class="opacity-0 -translate-y-1">
                            <div v-if="profileOpen" class="absolute right-0 z-50 mt-2 w-56 rounded-2xl border border-slate-100 bg-white p-1.5 shadow-soft">
                                <div class="flex items-center gap-2.5 border-b border-slate-100 px-3 py-2.5">
                                    <img v-if="user?.avatar" :src="user.avatar" class="h-9 w-9 rounded-full object-cover" />
                                    <span v-else class="flex h-9 w-9 items-center justify-center rounded-full bg-pjs-blue/10 text-pjs-blue"><i class="bi bi-person"></i></span>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-800">{{ user?.name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ user?.role === 'super_admin' ? 'Super Admin' : 'ผู้ดูแลระบบ' }}</p>
                                    </div>
                                </div>
                                <Link :href="route('profile.edit')" class="mt-1 flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm text-slate-600 hover:bg-slate-50" @click="profileOpen = false">
                                    <i class="bi bi-person-gear text-pjs-blue/70"></i> แก้ไขโปรไฟล์
                                </Link>
                                <button class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50" @click="logout">
                                    <i class="bi bi-box-arrow-right"></i> ออกจากระบบ
                                </button>
                            </div>
                        </Transition>
                    </div>
                    <button class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100 lg:hidden" @click="mobileOpen = !mobileOpen">
                        <i class="bi bi-list text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- click-away backdrop -->
            <div v-if="openGroup || profileOpen" class="fixed inset-0 z-30" @click="openGroup = null; profileOpen = false"></div>

            <!-- Mobile nav -->
            <Transition enter-active-class="transition" enter-from-class="opacity-0" leave-active-class="transition" leave-to-class="opacity-0">
                <nav v-if="mobileOpen" class="mx-auto mt-2 max-w-6xl rounded-2xl border border-slate-100 bg-white p-3 shadow-soft lg:hidden">
                    <div v-for="g in visibleNav" :key="g.label" class="mb-2">
                        <p class="px-2 pb-1 text-[10px] font-semibold uppercase tracking-wider text-slate-400">{{ g.label }}</p>
                        <template v-for="item in (g.items || [g])" :key="item.name">
                            <Link v-if="hasRoute(item.name)" :href="route(item.name)" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-sm text-slate-600 hover:bg-slate-50">
                                <i :class="item.icon" class="text-pjs-blue/70"></i>{{ item.label }}
                            </Link>
                        </template>
                    </div>
                </nav>
            </Transition>
        </header>

        <!-- Flash -->
        <div v-if="flash.success || flash.error" class="mx-auto max-w-6xl px-4 pt-4">
            <div v-if="flash.success" class="flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-2.5 text-sm text-green-800"><i class="bi bi-check-circle"></i>{{ flash.success }}</div>
            <div v-if="flash.error" class="flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm text-red-800"><i class="bi bi-x-circle"></i>{{ flash.error }}</div>
        </div>

        <!-- Page -->
        <main class="mx-auto max-w-6xl px-4 py-5">
            <div v-if="$slots.title" class="mb-4">
                <h1 class="text-lg font-semibold text-slate-800"><slot name="title" /></h1>
            </div>
            <slot />
        </main>

        <!-- Footer / license -->
        <footer class="mx-auto max-w-6xl px-4 pb-6 pt-2">
            <div class="flex flex-col items-center justify-between gap-2 border-t border-slate-200/70 pt-4 text-center text-xs text-slate-400 sm:flex-row sm:text-left">
                <p>© {{ currentYear }} PJS Law and Accounting Co., Ltd. — สงวนลิขสิทธิ์</p>
                <p>ระบบจัดการเว็บไซต์ <span class="text-slate-300">·</span> เวอร์ชัน 1.0</p>
            </div>
        </footer>
    </div>
</template>
