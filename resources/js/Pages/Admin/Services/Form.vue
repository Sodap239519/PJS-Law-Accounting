<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import LocalizedContent from '@/Components/Admin/LocalizedContent.vue';

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
        <form class="space-y-6" @submit.prevent="submit">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-lg font-semibold text-slate-800">{{ isEdit ? 'แก้ไขบริการ' : 'เพิ่มบริการ' }}</h1>
                <div class="pjs-card flex flex-wrap items-center gap-2 py-2 pl-4 pr-2">
                    <label class="flex items-center gap-1.5 text-sm font-medium text-slate-600">
                        <input v-model="form.is_active" type="checkbox" class="rounded" /> เปิดใช้งาน
                    </label>
                    <Link :href="route('admin.services.index')" class="btn-outline btn-sm">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: title + content + icon -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <LocalizedContent
                            v-model:title="form.title"
                            v-model:content="form.content"
                            v-model:translations="form.translations"
                            title-label="ชื่อบริการ"
                            content-label="รายละเอียด"
                            :title-error="form.errors.title"
                            :content-error="form.errors.content"
                            :content-height="560"
                        />

                        <label class="mb-1 mt-5 block text-sm font-medium text-slate-600">
                            ไอคอน (Bootstrap Icon) <i v-if="form.icon" :class="form.icon" class="ml-1 text-pjs-blue"></i>
                        </label>
                        <input v-model="form.icon" type="text" placeholder="เช่น bi bi-briefcase" class="field sm:max-w-md" />
                        <p class="mt-1 text-xs text-slate-400">ดูรายชื่อไอคอนได้ที่ icons.getbootstrap.com</p>
                    </div>
                </div>

                <!-- RIGHT: cover + actions -->
                <div class="space-y-5">
                    <CoverUploader
                        card
                        :ratio="16 / 9"
                        :existing="service?.cover"
                        label="รูปประกอบ (ไม่ใส่ก็ได้)"
                        hint="ถ้ามีรูป จะแสดงแทนไอคอนบนหน้าเว็บ"
                        @update:file="form.cover = $event"
                        @update:remove="form.remove_cover = $event"
                    />

                    <!-- Settings + actions -->
                    <div class="pjs-card p-5">
                        <label class="mb-1 block text-sm font-medium text-slate-600">ลำดับการแสดง</label>
                        <input v-model="form.sort_order" type="number" class="field mb-4" />

                        <div class="flex flex-wrap items-center gap-2">
                            <label class="flex items-center gap-1.5 rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium text-slate-600">
                                <input v-model="form.is_active" type="checkbox" class="rounded" /> เปิดใช้งาน
                            </label>
                            <Link :href="route('admin.services.index')" class="btn-outline ml-auto">ยกเลิก</Link>
                            <button type="submit" :disabled="form.processing" class="btn-primary">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
