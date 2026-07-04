<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import GalleryUploader from '@/Components/Admin/GalleryUploader.vue';
import FileAttachments from '@/Components/Admin/FileAttachments.vue';
import LinksRepeater from '@/Components/Admin/LinksRepeater.vue';

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
    attachments: [],
    deleted_media: [],
    links: props.caseStudy?.links ? [...props.caseStudy.links] : [],
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
        <template #title>{{ isEdit ? 'แก้ไขคดีตัวอย่าง' : 'เพิ่มคดีตัวอย่าง' }}</template>

        <form class="mx-auto max-w-4xl space-y-6" @submit.prevent="submit">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="space-y-5 lg:col-span-2">
                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <label class="mb-1 block text-sm font-medium text-gray-700">หัวข้อ *</label>
                        <input v-model="form.title" type="text" class="w-full rounded-lg border-gray-300" />
                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>

                        <label class="mb-1 mt-4 block text-sm font-medium text-gray-700">ลูกความ (ถ้ามี)</label>
                        <input v-model="form.client_name" type="text" placeholder="เช่น ปกปิดข้อมูล, บริษัทเอกชน" class="w-full rounded-lg border-gray-300" />

                        <label class="mb-1 mt-4 block text-sm font-medium text-gray-700">เนื้อหา (ความท้าทาย / แนวทาง / ผลลัพธ์)</label>
                        <RichEditor v-model="form.content" />
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <CoverUploader
                            :ratio="16 / 9"
                            :existing="caseStudy?.cover"
                            label="รูปปก (16:9 — ไม่ใส่ก็ได้)"
                            @update:file="form.cover = $event"
                            @update:remove="form.remove_cover = $event"
                        />
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <GalleryUploader :existing="caseStudy?.gallery || []" @update:files="form.gallery = $event" @update:deleted="deletedGallery = $event" />
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <FileAttachments :existing="caseStudy?.attachments || []" @update:files="form.attachments = $event" @update:deleted="deletedAttachments = $event" />
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <LinksRepeater v-model="form.links" />
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <label class="mb-2 flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input v-model="form.is_published" type="checkbox" class="rounded" /> เผยแพร่
                        </label>
                        <label class="mb-1 mt-4 block text-sm font-medium text-gray-700">หมวดหมู่</label>
                        <select v-model="form.category_id" class="w-full rounded-lg border-gray-300 text-sm">
                            <option :value="null">— ไม่ระบุ —</option>
                            <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                        <label class="mb-1 mt-4 block text-sm font-medium text-gray-700">Slug (URL)</label>
                        <input v-model="form.slug" type="text" placeholder="เว้นว่างให้สร้างอัตโนมัติ" class="w-full rounded-lg border-gray-300 text-sm" />
                        <p v-if="form.errors.slug" class="mt-1 text-sm text-red-600">{{ form.errors.slug }}</p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-4 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                            {{ isEdit ? 'บันทึกการแก้ไข' : 'สร้าง' }}
                        </button>
                        <Link :href="route('admin.case-studies.index')" class="rounded-lg border px-4 py-2.5 text-center text-sm text-gray-600 hover:bg-gray-50">ยกเลิก</Link>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
