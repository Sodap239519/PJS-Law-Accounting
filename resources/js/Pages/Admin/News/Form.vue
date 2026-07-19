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
    news: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
});

const isEdit = computed(() => !!props.news);

// วันเวลาปัจจุบัน (รูปแบบ datetime-local: YYYY-MM-DDTHH:mm)
const nowLocal = () => {
    const d = new Date();
    const pad = (n) => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
};

const form = useForm({
    title: props.news?.title || '',
    slug: props.news?.slug || '',
    category_id: props.news?.category_id || null,
    excerpt: props.news?.excerpt || '', // คงค่าเดิม (ไม่มีช่องกรอกแล้ว)
    content: props.news?.content || '',
    is_published: props.news?.is_published ?? false,
    published_at: props.news?.published_at || nowLocal(),
    cover: null,
    remove_cover: false,
    gallery: [],
    gallery_order: [],
    attachments: [],
    deleted_media: [],
    links: props.news?.links ? [...props.news.links] : [],
    translations: props.news?.translations || null,
});

const deletedGallery = ref([]);
const deletedAttachments = ref([]);

const submitDraft = () => {
    form.is_published = false;
    submit();
};

const submit = () => {
    form.deleted_media = [...deletedGallery.value, ...deletedAttachments.value];

    if (isEdit.value) {
        form
            .transform((data) => ({ ...data, _method: 'put' }))
            .post(route('admin.news.update', props.news.id), { forceFormData: true });
    } else {
        form.post(route('admin.news.store'), { forceFormData: true });
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขข่าว' : 'เพิ่มข่าว'" />
    <AdminLayout>
        <form class="space-y-6" @submit.prevent="submit">
            <!-- Title + save (same row) -->
            <div id="form-actions-top" class="flex flex-wrap items-center gap-3">
                <h1 class="text-lg font-semibold text-slate-800">{{ isEdit ? 'แก้ไขข่าว' : 'เพิ่มข่าว' }}</h1>
                <div class="ml-auto flex flex-wrap items-center gap-2">
                    <!-- การ์ด: หมวดหมู่ + วันที่ -->
                    <div class="pjs-card flex flex-wrap items-center gap-2 p-2">
                        <select v-model="form.category_id" class="field w-auto" title="หมวดหมู่">
                            <option :value="null">— หมวดหมู่ —</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                        <input v-model="form.published_at" type="datetime-local" class="field w-auto" title="วันที่เผยแพร่" />
                    </div>
                    <!-- การ์ด: เผยแพร่ + ปุ่มบันทึก -->
                    <div class="pjs-card flex flex-wrap items-center gap-2 p-2">
                        <label class="flex items-center gap-1.5 px-1 text-sm font-medium text-slate-600">
                            <input v-model="form.is_published" type="checkbox" class="rounded" /> เผยแพร่
                        </label>
                        <Link :href="route('admin.news.index')" class="btn-outline btn-sm">ยกเลิก</Link>
                        <button type="button" :disabled="form.processing" class="btn-soft btn-sm" @click="submitDraft"><i class="bi bi-file-earmark"></i> บันทึกร่าง</button>
                        <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">{{ isEdit ? 'บันทึก' : 'สร้างข่าว' }}</button>
                    </div>
                </div>
            </div>

            <DraftManager :form="form" :fields="['title', 'content', 'excerpt', 'translations']" :storage-key="'news-' + (news?.id || 'new')" />

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: title + content (tall) -->
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <LocalizedContent
                            v-model:title="form.title"
                            v-model:content="form.content"
                            v-model:translations="form.translations"
                            title-label="หัวข้อข่าว"
                            content-label="เนื้อหาข่าว"
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

                <!-- RIGHT: cover + gallery + attachments + links + full actions -->
                <div class="space-y-5">
                    <CoverUploader
                        card
                        :ratio="16 / 9"
                        :existing="news?.cover"
                        label="ภาพปกข่าว"
                        hint="ภาพหลักของข่าวบนหน้าเว็บและการ์ดข่าว"
                        @update:file="form.cover = $event"
                        @update:remove="form.remove_cover = $event"
                    />

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <i class="bi bi-images text-pjs-blue/70"></i> ภาพประกอบ
                        </h3>
                        <GalleryUploader
                            :existing="news?.gallery || []"
                            label=""
                            @update:files="form.gallery = $event"
                            @update:order="form.gallery_order = $event"
                            @update:deleted="deletedGallery = $event"
                        />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <i class="bi bi-paperclip text-pjs-blue/70"></i> ไฟล์แนบ
                        </h3>
                        <FileAttachments
                            :existing="news?.attachments || []"
                            label=""
                            @update:files="form.attachments = $event"
                            @update:deleted="deletedAttachments = $event"
                        />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <i class="bi bi-link-45deg text-pjs-blue/70"></i> ลิงก์แนบ
                        </h3>
                        <LinksRepeater v-model="form.links" />
                    </div>

                    <!-- Publish settings + actions (bottom) -->
                    <div class="pjs-card p-5">
                        <label class="mb-1 block text-sm font-medium text-slate-600">หมวดหมู่</label>
                        <select v-model="form.category_id" class="field mb-3">
                            <option :value="null">— ไม่ระบุ —</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>

                        <label class="mb-1 block text-sm font-medium text-slate-600">วันที่เผยแพร่</label>
                        <input v-model="form.published_at" type="datetime-local" class="field mb-4" />

                        <p class="mb-3 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-700">
                            หากไม่เลือก <strong>“เผยแพร่”</strong> ระบบจะบันทึกเป็น<strong>ร่างข่าว</strong>เท่านั้น (ยังไม่แสดงบนหน้าเว็บ)
                        </p>

                        <div class="flex flex-wrap items-center gap-2">
                            <label class="flex items-center gap-1.5 rounded-lg bg-slate-50 px-3 py-2 text-sm font-medium text-slate-600">
                                <input v-model="form.is_published" type="checkbox" class="rounded" /> เผยแพร่
                            </label>
                            <div class="ml-auto flex flex-wrap items-center justify-end gap-2">
                                <Link :href="route('admin.news.index')" class="btn-outline btn-sm">ยกเลิก</Link>
                                <button type="button" :disabled="form.processing" class="btn-soft btn-sm" @click="submitDraft"><i class="bi bi-file-earmark"></i> บันทึกร่าง</button>
                                <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">{{ isEdit ? 'บันทึก' : 'สร้างข่าว' }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <FloatingSaveBar :processing="form.processing" :save-label="isEdit ? 'บันทึก' : 'สร้างข่าว'" @save="submit" @cancel="router.visit(route('admin.news.index'))" />
    </AdminLayout>
</template>
