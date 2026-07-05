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
    news: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
});

const isEdit = computed(() => !!props.news);

const form = useForm({
    title: props.news?.title || '',
    slug: props.news?.slug || '',
    category_id: props.news?.category_id || null,
    excerpt: props.news?.excerpt || '', // คงค่าเดิม (ไม่มีช่องกรอกแล้ว)
    content: props.news?.content || '',
    is_published: props.news?.is_published ?? false,
    published_at: props.news?.published_at || '',
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
        <template #title>{{ isEdit ? 'แก้ไขข่าว' : 'เพิ่มข่าว' }}</template>

        <form class="space-y-6" @submit.prevent="submit">
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: cover + title/content -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Cover preview card -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <i class="bi bi-image text-pjs-blue/70"></i> ภาพปกข่าว
                        </h3>
                        <CoverUploader
                            :ratio="16 / 9"
                            :existing="news?.cover"
                            label="รูปปก (16:9)"
                            hint="รูปนี้จะแสดงเป็นภาพหลักของข่าวบนหน้าเว็บและการ์ดข่าว"
                            @update:file="form.cover = $event"
                            @update:remove="form.remove_cover = $event"
                        />
                    </div>

                    <!-- Title + content (language tabs) -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <LocalizedContent
                            v-model:title="form.title"
                            v-model:content="form.content"
                            v-model:translations="form.translations"
                            title-label="หัวข้อข่าว"
                            content-label="เนื้อหาข่าว"
                            :title-error="form.errors.title"
                            :content-error="form.errors.content"
                        />
                    </div>
                </div>

                <!-- RIGHT: publish + media + links + submit -->
                <div class="space-y-5">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700">
                            <i class="bi bi-send text-pjs-blue/70"></i> การเผยแพร่
                        </h3>
                        <label class="mb-2 flex items-center gap-2 text-sm font-medium text-slate-600">
                            <input v-model="form.is_published" type="checkbox" class="rounded" />
                            เผยแพร่
                        </label>

                        <label class="mb-1 mt-3 block text-sm font-medium text-slate-600">วันที่เผยแพร่</label>
                        <input v-model="form.published_at" type="datetime-local" class="w-full rounded-lg border-slate-200 text-sm" />

                        <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">หมวดหมู่</label>
                        <select v-model="form.category_id" class="w-full rounded-lg border-slate-200 text-sm">
                            <option :value="null">— ไม่ระบุ —</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>

                        <details class="mt-4 rounded-lg border border-slate-200 px-3 py-2">
                            <summary class="cursor-pointer select-none text-xs font-medium text-slate-500">ตั้งค่าขั้นสูง</summary>
                            <label class="mb-1 mt-3 block text-xs text-slate-500">Slug (URL) — เว้นว่างให้ระบบสร้างให้อัตโนมัติ</label>
                            <input v-model="form.slug" type="text" class="w-full rounded-lg border-slate-200 text-sm" />
                            <p v-if="form.errors.slug" class="mt-1 text-sm text-red-500">{{ form.errors.slug }}</p>
                        </details>
                    </div>

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

                    <div class="flex flex-col gap-2">
                        <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-4 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                            {{ isEdit ? 'บันทึกการแก้ไข' : 'สร้างข่าว' }}
                        </button>
                        <Link :href="route('admin.news.index')" class="rounded-lg border px-4 py-2.5 text-center text-sm text-slate-600 hover:bg-slate-50">
                            ยกเลิก
                        </Link>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
