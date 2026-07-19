<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import LoadingIndicator from '@/Components/Admin/LoadingIndicator.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash || {});
const unread = computed(() => page.props.unreadMessages || 0);
// โลโก้/ชื่อบริษัทจริง (จัดการที่ ตั้งค่าระบบ › โลโก้/ชื่อเว็บ) — สำรองด้วยตราสัญลักษณ์แอป
const siteName = computed(() => page.props.site?.name || 'PJS');
const siteLogo = computed(() => page.props.site?.logo || '/web-app-manifest-192x192.png');

const mobileOpen = ref(false);
const openGroup = ref(null);
const profileOpen = ref(false);
const modeMenuOpen = ref(false);

// ===== โหมดการแสดงผล: auto | desktop | mobile =====
const viewMode = ref('auto');
const winWidth = ref(typeof window !== 'undefined' ? window.innerWidth : 1280);
const isNarrow = computed(() => winWidth.value < 1024);
const isMobileUI = computed(() => viewMode.value === 'mobile' || (viewMode.value === 'auto' && isNarrow.value));
const modeLabel = { auto: 'อัตโนมัติ', desktop: 'ไซต์เดสก์ท็อป', mobile: 'ไซต์มือถือ' };
const modeIcon = computed(() => (viewMode.value === 'desktop' ? 'bi-display' : viewMode.value === 'mobile' ? 'bi-phone' : 'bi-aspect-ratio'));

const applyViewport = () => {
    const m = document.querySelector('meta[name="viewport"]');
    if (!m) return;
    // "ไซต์เดสก์ท็อป" บนมือถือ = บังคับความกว้าง 1280 แล้วให้เครื่องย่อ
    m.setAttribute('content', viewMode.value === 'desktop' ? 'width=1280' : 'width=device-width, initial-scale=1, viewport-fit=cover');
};
const setViewMode = (mode) => {
    viewMode.value = mode;
    try { localStorage.setItem('pjs-admin-view', mode); } catch (e) {}
    applyViewport();
};
const onResize = () => (winWidth.value = window.innerWidth);

// ===== ขนาดตัวอักษร (admin) =====
const adminFs = ref(1);
const applyFs = () => (document.documentElement.style.fontSize = 16 * adminFs.value + 'px');
const fsStep = (d) => {
    adminFs.value = Math.min(1.35, Math.max(0.85, Math.round((adminFs.value + d * 0.08) * 100) / 100));
    try { localStorage.setItem('pjs-admin-fs', adminFs.value); } catch (e) {}
    applyFs();
};

// ===== โหมดสี (admin) =====
const adminTheme = ref('light');
const applyTheme = () => document.documentElement.classList.toggle('pjs-admin-dark', adminTheme.value === 'dark');
const setTheme = (t) => {
    adminTheme.value = t;
    try { localStorage.setItem('pjs-admin-theme', t); } catch (e) {}
    applyTheme();
};

// ===== ภาษา (เก็บค่าที่มีผลกับหน้าเว็บสาธารณะ) =====
const adminLang = ref('th');
const setLang = (l) => {
    adminLang.value = l;
    try { localStorage.setItem('preferredLanguage', l); } catch (e) {}
    if (typeof window !== 'undefined' && window.pjsChangeLanguage) window.pjsChangeLanguage(l);
};

// ล็อกการเลื่อนพื้นหลังเมื่อเปิดเมนูมือถือ (ให้เลื่อนเฉพาะในเมนู)
watch(mobileOpen, (open) => {
    if (typeof document !== 'undefined') document.body.style.overflow = open ? 'hidden' : '';
});

// เมนูล่างสำหรับมือถือ (ถนัดขวา เอื้อมนิ้วโป้งถึง)
// ซ้าย 2 · กลางเป็น "ข้อความ" ทรงกลมลอยสูง · ขวา 1 + เมนู
const bottomLeft = [
    { label: 'แดชบอร์ด', name: 'admin.dashboard', icon: 'bi bi-grid-1x2' },
    { label: 'ข่าวสาร', name: 'admin.news.index', icon: 'bi bi-newspaper' },
];
const bottomRight = [
    { label: 'ประชาสัมพันธ์', name: 'admin.announcements.index', icon: 'bi bi-megaphone' },
];

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
        { label: 'จัดการหน้าแรก', name: 'admin.home-layout.edit', icon: 'bi bi-layout-text-window' },
        { label: 'แบนเนอร์', name: 'admin.banners.index', icon: 'bi bi-image' },
        { label: 'เอกสารดาวน์โหลด', name: 'admin.documents.index', icon: 'bi bi-cloud-arrow-down' },
        { label: 'กล่องข้อความ', name: 'admin.contacts.index', icon: 'bi bi-envelope' },
        { label: 'จัดการเมนู', name: 'admin.menus.index', icon: 'bi bi-list-nested', superAdmin: true },
        { label: 'จัดการหมวดหมู่', name: 'admin.categories.index', icon: 'bi bi-tags' },
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

// เปิดได้ทีละ dropdown เท่านั้น (ปิดตัวอื่นเมื่อเปิดตัวใหม่)
const toggleGroup = (label) => {
    profileOpen.value = false;
    modeMenuOpen.value = false;
    openGroup.value = openGroup.value === label ? null : label;
};
const toggleMode = () => {
    openGroup.value = null;
    profileOpen.value = false;
    modeMenuOpen.value = !modeMenuOpen.value;
};
const toggleProfile = () => {
    openGroup.value = null;
    modeMenuOpen.value = false;
    profileOpen.value = !profileOpen.value;
};

const logout = () => router.post(route('logout'));

// ปิดเมนู/ดรอปดาวน์ทุกครั้งที่เริ่มนำทาง (ไม่ต้องผูก @click ที่ทำให้ Link ถูก unmount ก่อนนำทาง)
let offStart = null;
onMounted(() => {
    try {
        const v = localStorage.getItem('pjs-admin-view'); if (v) viewMode.value = v;
        const fs = parseFloat(localStorage.getItem('pjs-admin-fs')); if (!isNaN(fs)) adminFs.value = fs;
        adminTheme.value = localStorage.getItem('pjs-admin-theme') === 'dark' ? 'dark' : 'light';
        adminLang.value = localStorage.getItem('preferredLanguage') || 'th';
    } catch (e) {}
    applyViewport();
    applyFs();
    applyTheme();
    window.addEventListener('resize', onResize);
    offStart = router.on('start', () => {
        openGroup.value = null;
        profileOpen.value = false;
        mobileOpen.value = false;
        modeMenuOpen.value = false;
    });
});
onUnmounted(() => {
    offStart?.();
    window.removeEventListener('resize', onResize);
});

const currentYear = new Date().getFullYear();
</script>

<template>
    <div class="min-h-screen bg-pjs-bg text-slate-700">
        <LoadingIndicator />

        <!-- Floating pill header -->
        <header class="sticky top-0 z-40 px-3 pt-3">
            <div class="relative z-50 mx-auto flex h-14 max-w-6xl items-center gap-1 rounded-full border border-slate-200/70 bg-white/90 pl-4 pr-2 shadow-sm backdrop-blur">
                <!-- Brand -->
                <Link :href="route('admin.dashboard')" class="flex shrink-0 items-center gap-2">
                    <img :src="siteLogo" class="h-9 w-9 rounded-full object-contain" :alt="siteName" />
                    <span class="hidden text-sm font-bold text-slate-800 xl:block">{{ siteName }} Admin</span>
                </Link>

                <!-- Tabs (centered) -->
                <nav v-if="!isMobileUI" class="mx-1 hidden flex-1 items-center justify-center gap-0.5 lg:flex">
                    <template v-for="g in visibleNav" :key="g.label">
                        <template v-if="!g.items">
                            <Link
                                v-if="hasRoute(g.name)"
                                :href="route(g.name)"
                                class="flex shrink-0 items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1.5 text-sm transition"
                                :class="groupActive(g) ? 'bg-pjs-blue text-white shadow' : 'text-slate-500 hover:bg-slate-100'"
                            >
                                {{ g.label }}
                            </Link>
                            <span v-else class="flex shrink-0 cursor-default items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1.5 text-sm text-slate-300" title="เร็วๆนี้">
                                {{ g.label }}
                            </span>
                        </template>
                        <div v-else class="relative shrink-0">
                            <button
                                class="flex items-center gap-1 whitespace-nowrap rounded-full px-2.5 py-1.5 text-sm transition"
                                :class="groupActive(g) || openGroup === g.label ? 'bg-pjs-blue text-white shadow' : 'text-slate-500 hover:bg-slate-100'"
                                @click="toggleGroup(g.label)"
                            >
                                {{ g.label }}
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
                    <!-- ตั้งค่าการแสดงผล (รวม ขนาดอักษร/ภาษา/โหมดสี/ไซต์) -->
                    <div class="relative">
                        <button class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100" title="ตั้งค่าการแสดงผล" @click="toggleMode">
                            <i class="bi bi-sliders text-base"></i>
                        </button>
                        <Transition enter-active-class="transition duration-100" enter-from-class="opacity-0 -translate-y-1" leave-active-class="transition duration-100" leave-to-class="opacity-0 -translate-y-1">
                            <div v-if="modeMenuOpen" class="absolute right-0 z-50 mt-2 w-60 rounded-2xl border border-slate-100 bg-white p-2 shadow-soft">
                                <!-- ขนาดตัวอักษร -->
                                <div class="px-1.5 py-1.5">
                                    <p class="mb-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-slate-400"><i class="bi bi-fonts"></i> ขนาดตัวอักษร</p>
                                    <div class="flex gap-1">
                                        <button class="flex-1 rounded-lg border border-slate-200 py-1.5 text-sm text-slate-600 hover:border-pjs-blue hover:text-pjs-blue" @click="fsStep(-1)">A&minus;</button>
                                        <span class="flex-1 rounded-lg bg-slate-50 py-1.5 text-center text-xs font-medium text-slate-500">{{ Math.round(adminFs * 100) }}%</span>
                                        <button class="flex-1 rounded-lg border border-slate-200 py-1.5 text-sm text-slate-600 hover:border-pjs-blue hover:text-pjs-blue" @click="fsStep(1)">A+</button>
                                    </div>
                                </div>
                                <!-- ภาษา -->
                                <div class="px-1.5 py-1.5">
                                    <p class="mb-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-slate-400"><i class="bi bi-translate"></i> ภาษา</p>
                                    <div class="flex gap-1">
                                        <button v-for="l in [{ c: 'th', t: 'ไทย' }, { c: 'en', t: 'EN' }, { c: 'zh-CN', t: '中文' }]" :key="l.c" class="flex-1 rounded-lg border py-1.5 text-xs transition" :class="adminLang === l.c ? 'border-pjs-blue bg-pjs-blue/10 font-medium text-pjs-blue' : 'border-slate-200 text-slate-600 hover:border-pjs-blue'" @click="setLang(l.c)">{{ l.t }}</button>
                                    </div>
                                </div>
                                <!-- โหมดสี -->
                                <div class="px-1.5 py-1.5">
                                    <p class="mb-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-slate-400"><i class="bi bi-circle-half"></i> โหมดสี</p>
                                    <div class="flex gap-1">
                                        <button class="flex-1 rounded-lg border py-1.5 text-xs transition" :class="adminTheme === 'light' ? 'border-pjs-blue bg-pjs-blue/10 font-medium text-pjs-blue' : 'border-slate-200 text-slate-600'" @click="setTheme('light')"><i class="bi bi-sun"></i> สว่าง</button>
                                        <button class="flex-1 rounded-lg border py-1.5 text-xs transition" :class="adminTheme === 'dark' ? 'border-pjs-blue bg-pjs-blue/10 font-medium text-pjs-blue' : 'border-slate-200 text-slate-600'" @click="setTheme('dark')"><i class="bi bi-moon-stars"></i> มืด</button>
                                    </div>
                                </div>
                                <!-- ไซต์แสดงผล -->
                                <div class="px-1.5 py-1.5">
                                    <p class="mb-1.5 flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-slate-400"><i class="bi bi-display"></i> ไซต์แสดงผล</p>
                                    <div class="flex gap-1">
                                        <button v-for="m in ['auto', 'desktop', 'mobile']" :key="m" class="flex-1 rounded-lg border py-1.5 text-[11px] transition" :class="viewMode === m ? 'border-pjs-blue bg-pjs-blue/10 font-medium text-pjs-blue' : 'border-slate-200 text-slate-600'" @click="setViewMode(m)">{{ m === 'auto' ? 'อัตโนมัติ' : m === 'desktop' ? 'เดสก์ท็อป' : 'มือถือ' }}</button>
                                    </div>
                                </div>
                            </div>
                        </Transition>
                    </div>

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
                        <button class="flex h-9 w-9 items-center justify-center rounded-full transition hover:ring-2 hover:ring-pjs-blue/30" title="โปรไฟล์" @click="toggleProfile">
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
                    <button v-if="isMobileUI" class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 hover:bg-slate-100" @click="mobileOpen = !mobileOpen">
                        <i class="bi bi-list text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- click-away backdrop -->
            <div v-if="openGroup || profileOpen || modeMenuOpen" class="fixed inset-0 z-30" @click="openGroup = null; profileOpen = false; modeMenuOpen = false"></div>

            <!-- Mobile nav (overlay ที่เลื่อนในตัวเอง ไม่เลื่อนพื้นหลัง) -->
            <Transition enter-active-class="transition" enter-from-class="opacity-0" leave-active-class="transition" leave-to-class="opacity-0">
                <div v-if="mobileOpen" class="fixed inset-0 z-40 bg-slate-900/30 backdrop-blur-sm" @click="mobileOpen = false"></div>
            </Transition>
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="-translate-y-2 opacity-0"
                leave-active-class="transition duration-150 ease-in"
                leave-to-class="-translate-y-2 opacity-0"
            >
                <nav
                    v-if="mobileOpen"
                    class="fixed inset-x-3 top-[76px] z-50 max-h-[calc(100vh-92px)] overflow-y-auto overscroll-contain rounded-2xl border border-slate-100 bg-white p-3 shadow-soft"
                >
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
        <main class="mx-auto max-w-6xl px-4 py-5" :class="isMobileUI ? 'pb-24' : ''">
            <div v-if="$slots.title" class="mb-4">
                <h1 class="text-lg font-semibold text-slate-800"><slot name="title" /></h1>
            </div>
            <slot />
        </main>

        <!-- Bottom nav (มือถือ — ถนัดขวา เอื้อมนิ้วโป้งถึง) -->
        <Transition enter-active-class="transition duration-200" enter-from-class="translate-y-full" leave-active-class="transition duration-150" leave-to-class="translate-y-full">
            <nav v-if="isMobileUI" class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200/70 bg-white/95 shadow-[0_-4px_20px_-8px_rgba(0,0,0,0.15)] backdrop-blur" style="padding-bottom: env(safe-area-inset-bottom)">
                <div class="mx-auto flex max-w-lg items-end justify-around px-1">
                    <!-- ซ้าย -->
                    <Link
                        v-for="b in bottomLeft"
                        :key="b.name"
                        :href="hasRoute(b.name) ? route(b.name) : '#'"
                        class="flex flex-1 flex-col items-center gap-0.5 py-2.5 text-[10px] transition"
                        :class="isActive(b.name) ? 'text-pjs-blue' : 'text-slate-400'"
                    >
                        <i :class="b.icon" class="text-lg"></i>
                        <span>{{ b.label }}</span>
                    </Link>

                    <!-- กลาง: ข้อความ (ทรงกลมสีฟ้าลอยสูง + badge) เฉพาะไอคอน -->
                    <Link :href="hasRoute('admin.contacts.index') ? route('admin.contacts.index') : '#'" class="flex flex-1 flex-col items-center py-2.5" title="ข้อความ">
                        <span class="relative -mt-7 flex h-14 w-14 items-center justify-center rounded-full bg-pjs-blue text-white shadow-[0_6px_16px_-4px_rgba(37,99,235,0.6)] ring-4 ring-white">
                            <i class="bi bi-envelope text-xl"></i>
                            <span v-if="unread > 0" class="absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-red-500 px-1 text-[9px] font-bold text-white ring-2 ring-white">{{ unread > 99 ? '99+' : unread }}</span>
                        </span>
                    </Link>

                    <!-- ขวา -->
                    <Link
                        v-for="b in bottomRight"
                        :key="b.name"
                        :href="hasRoute(b.name) ? route(b.name) : '#'"
                        class="flex flex-1 flex-col items-center gap-0.5 py-2.5 text-[10px] transition"
                        :class="isActive(b.name) ? 'text-pjs-blue' : 'text-slate-400'"
                    >
                        <i :class="b.icon" class="text-lg"></i>
                        <span>{{ b.label }}</span>
                    </Link>
                    <button type="button" class="flex flex-1 flex-col items-center gap-0.5 py-2.5 text-[10px] text-slate-400 transition hover:text-slate-600" @click="mobileOpen = true">
                        <i class="bi bi-grid-3x3-gap text-lg"></i>
                        <span>เมนู</span>
                    </button>
                </div>
            </nav>
        </Transition>

        <!-- Footer / license -->
        <footer class="mx-auto max-w-6xl px-4 pb-6 pt-2" :class="isMobileUI ? 'pb-24' : ''">
            <div class="flex flex-col items-center justify-between gap-1 border-t border-slate-200/70 pt-4 text-center text-[10px] text-slate-400 sm:flex-row sm:text-left sm:text-xs">
                <p class="whitespace-nowrap">© {{ currentYear }} PJS Law and Accounting Co., Ltd.</p>
                <p class="whitespace-nowrap">สงวนลิขสิทธิ์ <span class="text-slate-300">·</span> ระบบจัดการเว็บไซต์ v1.0</p>
            </div>
        </footer>
    </div>
</template>
