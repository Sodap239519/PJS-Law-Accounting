<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    contacts: { type: Object, required: true },
    filter: { type: String, default: null },
    unreadCount: { type: Number, default: 0 },
});

const setFilter = (f) => router.get(route('admin.contacts.index'), f ? { filter: f } : {}, { preserveState: true, replace: true });

const destroy = (id) => {
    if (confirm('ยืนยันการลบข้อความนี้?')) router.delete(route('admin.contacts.destroy', id));
};
</script>

<template>
    <Head title="กล่องข้อความ" />
    <AdminLayout>
        <template #title>กล่องข้อความ</template>

        <div class="mb-4 flex items-center gap-2">
            <button class="rounded-full px-4 py-1.5 text-sm" :class="!filter ? 'bg-pjs-blue text-white' : 'bg-white text-slate-500 hover:bg-slate-100'" @click="setFilter(null)">ทั้งหมด</button>
            <button class="flex items-center gap-2 rounded-full px-4 py-1.5 text-sm" :class="filter === 'unread' ? 'bg-pjs-blue text-white' : 'bg-white text-slate-500 hover:bg-slate-100'" @click="setFilter('unread')">
                ยังไม่อ่าน
                <span v-if="unreadCount > 0" class="rounded-full bg-red-500 px-1.5 text-[10px] font-bold text-white">{{ unreadCount }}</span>
            </button>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
            <ul class="divide-y divide-slate-100">
                <li v-for="c in contacts.data" :key="c.id" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50" :class="!c.is_read ? 'bg-pjs-blue/[0.03]' : ''">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full" :class="!c.is_read ? 'bg-pjs-blue/10 text-pjs-blue' : 'bg-slate-100 text-slate-400'">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <Link :href="route('admin.contacts.show', c.id)" class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="truncate text-sm" :class="!c.is_read ? 'font-semibold text-slate-800' : 'text-slate-600'">{{ c.name }}</span>
                            <span v-if="!c.is_read" class="h-2 w-2 shrink-0 rounded-full bg-pjs-blue"></span>
                        </div>
                        <p class="truncate text-xs text-slate-500">{{ c.subject }}</p>
                    </Link>
                    <div class="hidden shrink-0 text-right text-xs text-slate-400 sm:block">
                        <p>{{ c.phone }}</p>
                        <p>{{ c.date }}</p>
                    </div>
                    <button class="shrink-0 rounded-lg p-2 text-slate-300 hover:bg-red-50 hover:text-red-500" @click="destroy(c.id)"><i class="bi bi-trash"></i></button>
                </li>
                <li v-if="!contacts.data.length" class="px-4 py-12 text-center text-sm text-slate-400">
                    <i class="bi bi-inbox mb-2 block text-3xl"></i>ยังไม่มีข้อความ
                </li>
            </ul>
        </div>

        <div v-if="contacts.links && contacts.links.length > 3" class="mt-4 flex flex-wrap gap-1">
            <component
                :is="link.url ? Link : 'span'"
                v-for="(link, i) in contacts.links"
                :key="i"
                :href="link.url"
                class="rounded border px-3 py-1 text-sm"
                :class="link.active ? 'bg-pjs-blue text-white' : link.url ? 'bg-white text-slate-600 hover:bg-slate-50' : 'text-slate-300'"
                v-html="link.label"
            />
        </div>
    </AdminLayout>
</template>
