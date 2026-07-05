<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import GalleryUploader from '@/Components/Admin/GalleryUploader.vue';
import FileAttachments from '@/Components/Admin/FileAttachments.vue';
import LinksRepeater from '@/Components/Admin/LinksRepeater.vue';
import LocalizedContent from '@/Components/Admin/LocalizedContent.vue';

const props = defineProps({
    caseStudy: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
});

const isEdit = computed(() => !!props.caseStudy);

const form = useForm({
    title: props.caseStudy?.title || '',
    slug: props.caseStudy?.slug || '',
    client_name: props.caseStudy?.client_name || '',
    category_id: props.caseStudy?.category_id || null,
    content: props.caseStudy?.content || '',
    is_published: props.caseStudy?.is_published ?? false,
    cover: null,
    remove_cover: false,
    gallery: [],
    gallery_order: [],
    attachments: [],
    deleted_media: [],
    links: props.caseStudy?.links ? [...props.caseStudy.links] : [],
    translations: props.caseStudy?.translations || null,
});

const deletedGallery = ref([]);
const deletedAttachments = ref([]);

const submit = () => {
    form.deleted_media = [...deletedGallery.value, ...deletedAttachments.value];
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.case-studies.update', props.caseStudy.id), { forceFormData: true });
    } else {
        form.post(route('admin.case-studies.store'), { forceFormData: true });
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขคดีตัวอย่าง' : 'เพิ่มคดีตัวอย่าง'" />
    <AdminLayout>
        <form class="space-y-6" @submit.prevent="submit">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-lg font-semibold text-slate-800">{{ isEdit ? 'แก้ไขคดีตัวอย่าง' : 'เพิ่มคดีตัวอย่าง' }}</h1>
                <div class="pjs-card flex flex-wrap items-center gap-2 p-2">
                    <select v-model="form.category_id" class="field w-auto" title="หมวดหมู่">
                        <option :value="null">— หมวดหมู่ —</option>
                        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                    <label class="flex items-center gap-1.5 px-1 text-sm font-medium text-slate-600">
                        <input v-model="form.is_published" type="checkbox" class="rounded" /> เผยแพร่
                    </label>
                    <Link :href="route('admin.case-studies.index')" class="btn-outline btn-sm">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: title + content -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <LocalizedContent
                            v-model:title="form.title"
                            v-model:content="form.content"
                            v-model:translations="form.translations"
                            title-label="หัวข้อ"
                            content-label="เนื้อหา (ความท้าทาย / แนวทาง / ผลลัพธ์)"
                            :title-error="form.errors.title"
                            :content-error="form.errors.content"
                            :content-height="700"
                        />

                        <label class="mb-1 mt-5 block text-sm font-medium text-slate-600">ลูกความ (ถ้ามี)</label>
                        <input v-model="form.client_name" type="text" placeholder="เช่น ปกปิดข้อมูล, บริษัทเอกชน" class="field sm:max-w-md" />

                        <details class="mt-5 rounded-lg border border-slate-200 px-3 py-2">
                            <summary class="cursor-pointer select-none text-xs font-medium text-slate-500">ตั้งค่าขั้นสูง</summary>
                            <label class="mb-1 mt-3 block text-xs text-slate-500">Slug (URL) — เว้นว่างให้ระบบสร้างให้อัตโนมัติ</label>
                            <input v-model="form.slug" type="text" class="field sm:max-w-md" />
                            <p v-if="form.errors.slug" class="field-error">{{ form.errors.slug }}</p>
                        </details>
                    </div>
                </div>

                <!-- RIGHT: cover + media + links + actions -->
                <div class="space-y-5">
                    <CoverUploader
                        card
                        :ratio="16 / 9"
                        :existing="caseStudy?.cover"
                        label="รูปปก (16:9 — ไม่ใส่ก็ได้)"
                        hint="ภาพหลักของคดีบนหน้าเว็บ (ไม่บังคับ)"
                        @update:file="form.cover = $event"
                        @update:remove="form.remove_cover = $event"
                    />

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700"><i class="bi bi-images text-pjs-blue/70"></i> ภาพประกอบ</h3>
                        <GalleryUploader :existing="caseStudy?.gallery || []" label="" @update:files="form.gallery = $event" @update:order="form.gallery_order = $event" @update:deleted="deletedGallery = $event" />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700"><i class="bi bi-paperclip text-pjs-blue/70"></i> ไฟล์แนบ</h3>
                        <FileAttachments :existing="caseStudy?.attachments || []" label="" @update:files="form.attachments = $event" @update:deleted="deletedAttachments = $event" />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700"><i class="bi bi-link-45deg text-pjs-blue/70"></i> ลิงก์แนบ</h3>
                        <LinksRepeater v-model="form.links" />
                    </div>

                    <!-- Publish settings + actions -->
                    <div class="pjs-card p-5">
                        <label class="mb-1 block text-sm font-medium text-slate-600">หมวดหมู่</label>
                        <select v-model="form.category_id" class="field mb-4">
                            <option :value="null">— ไม่ระบุ —</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>

                        <p class="mb-3 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-700">
                            หากไม่เลือก <strong>“เผยแพร่”</strong> ระบบจะบันทึกเป็น<strong>ร่าง</strong>เท่านั้น (ยังไม่แสดงบนหน้าเว็บ)
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            <label class="flex items-center gap-1.5 rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium text-slate-600">
                                <input v-model="form.is_published" type="checkbox" class="rounded" /> เผยแพร่
                            </label>
                            <Link :href="route('admin.case-studies.index')" class="btn-outline ml-auto">ยกเลิก</Link>
                            <button type="submit" :disabled="form.processing" class="btn-primary">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
