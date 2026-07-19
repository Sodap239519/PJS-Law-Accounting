<script setup>
import { computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FloatingSaveBar from '@/Components/Admin/FloatingSaveBar.vue';
import DraftManager from '@/Components/Admin/DraftManager.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import LocalizedContent from '@/Components/Admin/LocalizedContent.vue';

const props = defineProps({
    service: { type: Object, default: null },
});

const isEdit = computed(() => !!props.service);

const form = useForm({
    title: props.service?.title || '',
    group: props.service?.group || '',
    icon: props.service?.icon || '',
    content: props.service?.content || '',
    sort_order: props.service?.sort_order ?? null,
    is_active: props.service?.is_active ?? true,
    cover: null,
    remove_cover: false,
    translations: props.service?.translations || null,
});

// ไอคอนให้เลือก (Bootstrap Icons — เหมาะกับกฎหมาย/บัญชี)
const iconOptions = [
    'bi bi-briefcase', 'bi bi-person-check', 'bi bi-file-earmark-text', 'bi bi-building', 'bi bi-shield-check', 'bi bi-search',
    'bi bi-hammer', 'bi bi-bank', 'bi bi-journal-text', 'bi bi-file-earmark-ruled', 'bi bi-graph-up-arrow', 'bi bi-people',
    'bi bi-laptop', 'bi bi-clipboard-data', 'bi bi-calculator', 'bi bi-receipt', 'bi bi-cash-coin', 'bi bi-wallet2',
    'bi bi-piggy-bank', 'bi bi-percent', 'bi bi-book', 'bi bi-award', 'bi bi-pencil-square', 'bi bi-telephone',
];

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
            <div id="form-actions-top" class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-lg font-semibold text-slate-800">{{ isEdit ? 'แก้ไขบริการ' : 'เพิ่มบริการ' }}</h1>
                <div class="pjs-card flex flex-wrap items-center gap-2 p-2">
                    <label class="flex items-center gap-1.5 px-1 text-sm font-medium text-slate-600">
                        <input v-model="form.is_active" type="checkbox" class="rounded" /> เปิดใช้งาน
                    </label>
                    <Link :href="route('admin.services.index')" class="btn-outline btn-sm">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
                </div>
            </div>

            <DraftManager :form="form" :fields="['title', 'content', 'icon', 'translations']" :storage-key="'service-' + (service?.id || 'new')" :enabled="!isEdit" />

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: title + content + icon -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <!-- กลุ่มบริการ (บนสุด) -->
                        <label class="field-label">กลุ่มบริการ (แสดงแยกกลุ่มบนหน้าเว็บ)</label>
                        <input v-model="form.group" type="text" list="service-groups" placeholder="เช่น ด้านกฎหมาย, ด้านบัญชี" class="field" />
                        <datalist id="service-groups">
                            <option value="ด้านกฎหมาย" />
                            <option value="ด้านบัญชี" />
                        </datalist>
                        <p class="mt-1 text-xs text-slate-400">บริการที่กลุ่มเดียวกันจะแสดงรวมกันบนหน้าเว็บ</p>

                        <!-- ไอคอน: เลือกจากตาราง -->
                        <label class="field-label mt-4">เลือกไอคอน <i v-if="form.icon" :class="form.icon" class="ml-1 text-pjs-blue"></i></label>
                        <div class="flex flex-wrap gap-1.5">
                            <button
                                v-for="ic in iconOptions"
                                :key="ic"
                                type="button"
                                class="flex h-9 w-9 items-center justify-center rounded-lg border text-lg transition"
                                :class="form.icon === ic ? 'border-pjs-blue bg-pjs-blue/10 text-pjs-blue' : 'border-slate-200 text-slate-400 hover:border-pjs-blue/50 hover:text-pjs-blue'"
                                :title="ic"
                                @click="form.icon = ic"
                            >
                                <i :class="ic"></i>
                            </button>
                        </div>

                        <div class="mt-5 border-t border-slate-100 pt-5">
                            <LocalizedContent
                                v-model:title="form.title"
                                v-model:content="form.content"
                                v-model:translations="form.translations"
                                title-label="ชื่อบริการ"
                                content-label="รายละเอียด"
                                :title-error="form.errors.title"
                                :content-error="form.errors.content"
                                :content-height="440"
                            />
                        </div>
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
                        <p class="mb-3 flex items-center gap-1.5 text-xs text-slate-400"><i class="bi bi-info-circle"></i> ลำดับจะถูกจัดให้อัตโนมัติ — ลากจัดลำดับได้ในหน้ารายการ</p>

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

        <FloatingSaveBar :processing="form.processing">
            <label class="flex items-center gap-1.5 whitespace-nowrap px-1 text-sm font-medium text-slate-600">
                <input v-model="form.is_active" type="checkbox" class="rounded" /> เปิดใช้งาน
            </label>
            <Link :href="route('admin.services.index')" class="btn-outline btn-sm">ยกเลิก</Link>
            <button type="button" :disabled="form.processing" class="btn-primary btn-sm" @click="submit">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
        </FloatingSaveBar>
    </AdminLayout>
</template>
