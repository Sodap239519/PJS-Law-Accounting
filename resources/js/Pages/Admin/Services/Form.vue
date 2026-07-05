<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import TranslationFields from '@/Components/Admin/TranslationFields.vue';

const props = defineProps({
    service: { type: Object, default: null },
});

const isEdit = computed(() => !!props.service);

const form = useForm({
    title: props.service?.title || '',
    icon: props.service?.icon || '',
    content: props.service?.content || '',
    sort_order: props.service?.sort_order ?? 0,
    is_active: props.service?.is_active ?? true,
    cover: null,
    remove_cover: false,
    translations: props.service?.translations || null,
});

const submit = () => {
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.services.update', props.service.id), { forceFormData: true });
    } else {
        form.post(route('admin.services.store'), { forceFormData: true });
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขบริการ' : 'เพิ่มบริการ'" />
    <AdminLayout>
        <template #title>{{ isEdit ? 'แก้ไขบริการ' : 'เพิ่มบริการ' }}</template>

        <form class="mx-auto max-w-3xl space-y-6" @submit.prevent="submit">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-1 block text-sm font-medium text-slate-600">ชื่อบริการ *</label>
                <input v-model="form.title" type="text" class="w-full rounded-lg border-slate-200" />
                <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">{{ form.errors.title }}</p>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-600">ไอคอน (Bootstrap Icon)</label>
                        <input v-model="form.icon" type="text" placeholder="เช่น bi bi-briefcase" class="w-full rounded-lg border-slate-200" />
                        <p class="mt-1 text-xs text-slate-400">
                            ดูรายชื่อไอคอนได้ที่ icons.getbootstrap.com — <i v-if="form.icon" :class="form.icon" class="text-pjs-blue"></i>
                        </p>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-600">ลำดับการแสดง</label>
                        <input v-model="form.sort_order" type="number" class="w-full rounded-lg border-slate-200" />
                    </div>
                </div>

                <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">รายละเอียด</label>
                <RichEditor v-model="form.content" />

                <label class="mb-2 mt-4 flex items-center gap-2 text-sm font-medium text-slate-600">
                    <input v-model="form.is_active" type="checkbox" class="rounded" /> เปิดใช้งาน
                </label>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <TranslationFields
                    v-model="form.translations"
                    :fields="[
                        { key: 'title', label: 'ชื่อบริการ', type: 'text' },
                        { key: 'content', label: 'รายละเอียด', type: 'rich' },
                    ]"
                />
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <CoverUploader
                    :ratio="16 / 9"
                    :existing="service?.cover"
                    label="รูปประกอบ (ไม่ใส่ก็ได้)"
                    @update:file="form.cover = $event"
                    @update:remove="form.remove_cover = $event"
                />
            </div>

            <div class="flex gap-2">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    {{ isEdit ? 'บันทึกการแก้ไข' : 'สร้างบริการ' }}
                </button>
                <Link :href="route('admin.services.index')" class="rounded-lg border px-5 py-2.5 text-center text-sm text-slate-600 hover:bg-slate-50">ยกเลิก</Link>
            </div>
        </form>
    </AdminLayout>
</template>
