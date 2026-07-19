<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FloatingSaveBar from '@/Components/Admin/FloatingSaveBar.vue';
import DraftManager from '@/Components/Admin/DraftManager.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import GalleryUploader from '@/Components/Admin/GalleryUploader.vue';
import FileAttachments from '@/Components/Admin/FileAttachments.vue';
import LinksRepeater from '@/Components/Admin/LinksRepeater.vue';
import LocalizedContent from '@/Components/Admin/LocalizedContent.vue';

const props = defineProps({
    announcement: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
    prefillDate: { type: String, default: null },
});

const isEdit = computed(() => !!props.announcement);

const nowLocal = () => {
    const d = new Date();
    const pad = (n) => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
};

const form = useForm({
    title: props.announcement?.title || '',
    slug: props.announcement?.slug || '',
    category_id: props.announcement?.category_id || null,
    excerpt: props.announcement?.excerpt || '', // คงค่าเดิม (ไม่มีช่องกรอกแล้ว)
    content: props.announcement?.content || '',
    is_published: props.announcement?.is_published ?? true, // เพิ่มใหม่: เผยแพร่ไว้ก่อน
    published_at: props.announcement?.published_at || (props.prefillDate ? props.prefillDate + 'T09:00' : nowLocal()),
    cover: null,
    remove_cover: false,
    gallery: [],
    gallery_order: [],
    attachments: [],
    deleted_media: [],
    links: props.announcement?.links ? [...props.announcement.links] : [],
    translations: props.announcement?.translations || null,
});

const deletedGallery = ref([]);
const deletedAttachments = ref([]);

const isScheduled = computed(() => form.is_published && form.published_at && new Date(form.published_at) > new Date());

const submitDraft = () => {
    form.is_published = false;
    submit();
};

const submit = () => {
    form.deleted_media = [...deletedGallery.value, ...deletedAttachments.value];
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.announcements.update', props.announcement.id), { forceFormData: true });
    } else {
        form.post(route('admin.announcements.store'), { forceFormData: true });
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขประชาสัมพันธ์' : 'เพิ่มประชาสัมพันธ์'" />
    <AdminLayout>
        <form class="space-y-6" @submit.prevent="submit">
            <div id="form-actions-top" class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-lg font-semibold text-slate-800">{{ isEdit ? 'แก้ไขประชาสัมพันธ์' : 'เพิ่มประชาสัมพันธ์' }}</h1>
                <div class="ml-auto flex flex-wrap items-center gap-2">
                    <div class="pjs-card flex flex-wrap items-center gap-2 p-2">
                        <select v-model="form.category_id" class="field w-auto" title="หมวดหมู่">
                            <option :value="null">— หมวดหมู่ —</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                        <input v-model="form.published_at" type="datetime-local" class="field w-auto" title="วันเวลาที่เผยแพร่" />
                    </div>
                    <div class="pjs-card flex items-center gap-2 p-2">
                        <label v-if="isEdit" class="flex shrink-0 items-center gap-1.5 whitespace-nowrap px-1 text-sm font-medium text-slate-600">
                            <input v-model="form.is_published" type="checkbox" class="rounded" /> เผยแพร่
                        </label>
                        <Link :href="route('admin.announcements.index')" class="btn-outline btn-sm">ยกเลิก</Link>
                        <button type="button" :disabled="form.processing" class="btn-soft btn-sm" @click="submitDraft"><i class="bi bi-file-earmark"></i> บันทึกร่าง</button>
                        <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
                    </div>
                </div>
            </div>

            <DraftManager :form="form" :fields="['title', 'content', 'excerpt', 'translations']" :storage-key="'announcement-' + (announcement?.id || 'new')" :enabled="!isEdit" />

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: title + content -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <LocalizedContent
                            v-model:title="form.title"
                            v-model:content="form.content"
                            v-model:translations="form.translations"
                            title-label="หัวข้อ"
                            content-label="เนื้อหา"
                            :title-error="form.errors.title"
                            :content-error="form.errors.content"
                            :content-height="700"
                        />

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
                        :ratio="4 / 5"
                        :existing="announcement?.cover"
                        label="รูปปก (4:5)"
                        hint="ภาพหลักของประชาสัมพันธ์บนหน้าเว็บ"
                        @update:file="form.cover = $event"
                        @update:remove="form.remove_cover = $event"
                    />

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700"><i class="bi bi-images text-pjs-blue/70"></i> ภาพประกอบ</h3>
                        <GalleryUploader :existing="announcement?.gallery || []" label="" @update:files="form.gallery = $event" @update:order="form.gallery_order = $event" @update:deleted="deletedGallery = $event" />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700"><i class="bi bi-paperclip text-pjs-blue/70"></i> ไฟล์แนบ</h3>
                        <FileAttachments :existing="announcement?.attachments || []" label="" @update:files="form.attachments = $event" @update:deleted="deletedAttachments = $event" />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700"><i class="bi bi-link-45deg text-pjs-blue/70"></i> ลิงก์แนบ</h3>
                        <LinksRepeater v-model="form.links" />
                    </div>

                    <p v-if="isScheduled" class="flex items-center gap-1.5 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-700">
                        <i class="bi bi-clock"></i> ตั้งเวลาโพสต์ — จะเผยแพร่อัตโนมัติเมื่อถึงวันเวลาที่กำหนดด้านบน
                    </p>
                </div>
            </div>
        </form>

        <FloatingSaveBar :processing="form.processing">
            <select v-model="form.category_id" class="field w-auto" title="หมวดหมู่">
                <option :value="null">— หมวดหมู่ —</option>
                <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
            <input v-model="form.published_at" type="datetime-local" class="field w-auto" title="วันเวลาที่เผยแพร่" />
            <label v-if="isEdit" class="flex items-center gap-1.5 whitespace-nowrap px-1 text-sm font-medium text-slate-600">
                <input v-model="form.is_published" type="checkbox" class="rounded" /> เผยแพร่
            </label>
            <Link :href="route('admin.announcements.index')" class="btn-outline btn-sm">ยกเลิก</Link>
            <button type="button" :disabled="form.processing" class="btn-soft btn-sm" @click="submitDraft"><i class="bi bi-file-earmark"></i> บันทึกร่าง</button>
            <button type="button" :disabled="form.processing" class="btn-primary btn-sm" @click="submit">{{ isEdit ? 'บันทึก' : 'สร้าง' }}</button>
        </FloatingSaveBar>
    </AdminLayout>
</template>
