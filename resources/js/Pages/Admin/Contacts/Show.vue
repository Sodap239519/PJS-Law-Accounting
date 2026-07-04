<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    contact: { type: Object, required: true },
});

const destroy = () => {
    if (confirm('ยืนยันการลบข้อความนี้?')) router.delete(route('admin.contacts.destroy', props.contact.id));
};
</script>

<template>
    <Head title="ข้อความ" />
    <AdminLayout>
        <template #title>รายละเอียดข้อความ</template>

        <div class="mx-auto max-w-2xl">
            <Link :href="route('admin.contacts.index')" class="mb-3 inline-flex items-center gap-1 text-sm text-slate-500 hover:text-pjs-blue">
                <i class="bi bi-chevron-left"></i> กลับกล่องข้อความ
            </Link>

            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                <div class="flex items-center gap-3 border-b border-slate-100 bg-slate-50 px-5 py-4">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-pjs-blue/10 text-pjs-blue"><i class="bi bi-person text-xl"></i></span>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-800">{{ contact.name }}</p>
                        <p class="text-xs text-slate-400">{{ contact.date }}</p>
                    </div>
                    <button class="ml-auto rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-600 hover:bg-red-50" @click="destroy">
                        <i class="bi bi-trash"></i> ลบ
                    </button>
                </div>

                <div class="space-y-4 px-5 py-5">
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div class="rounded-xl bg-slate-50 px-4 py-3">
                            <p class="text-xs text-slate-400">โทรศัพท์</p>
                            <a :href="`tel:${contact.phone}`" class="text-sm font-medium text-pjs-blue">{{ contact.phone }}</a>
                        </div>
                        <div class="rounded-xl bg-slate-50 px-4 py-3">
                            <p class="text-xs text-slate-400">อีเมล</p>
                            <a v-if="contact.email" :href="`mailto:${contact.email}`" class="text-sm font-medium text-pjs-blue">{{ contact.email }}</a>
                            <span v-else class="text-sm text-slate-400">—</span>
                        </div>
                    </div>

                    <div>
                        <p class="mb-1 text-xs text-slate-400">หัวข้อ</p>
                        <p class="font-medium text-slate-700">{{ contact.subject }}</p>
                    </div>

                    <div>
                        <p class="mb-1 text-xs text-slate-400">รายละเอียด</p>
                        <p class="whitespace-pre-line rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-600">{{ contact.details }}</p>
                    </div>

                    <div class="flex gap-2 pt-1">
                        <a v-if="contact.email" :href="`mailto:${contact.email}?subject=RE: ${contact.subject}`" class="flex items-center gap-2 rounded-lg bg-pjs-blue px-4 py-2 text-sm text-white hover:bg-pjs-blue-dark">
                            <i class="bi bi-reply"></i> ตอบกลับอีเมล
                        </a>
                        <a :href="`tel:${contact.phone}`" class="flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                            <i class="bi bi-telephone"></i> โทรกลับ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
