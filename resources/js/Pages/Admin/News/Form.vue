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
    news: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
});

const isEdit = computed(() => !!props.news);

const form = useForm({
    title: props.news?.title || '',
    slug: props.news?.slug || '',
    category_id: props.news?.category_id || null,
    excerpt: props.news?.excerpt || '',
    content: props.news?.content || '',
    is_published: props.news?.is_published ?? false,
    published_at: props.news?.published_at || '',
    cover: null,
    remove_cover: false,
    gallery: [],
    attachments: [],
    deleted_media: [],
    links: props.news?.links ? [...props.news.links] : [],
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

        <form class="mx-auto max-w-4xl space-y-6" @submit.prevent="submit">
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Main -->
                <div class="space-y-5 lg:col-span-2">
                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <label class="mb-1 block text-sm font-medium text-gray-700">หัวข้อ *</label>
                        <input v-model="form.title" type="text" class="w-full rounded-lg border-gray-300" />
                        <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>

                        <label class="mb-1 mt-4 block text-sm font-medium text-gray-700">เกริ่นนำ (ย่อ)</label>
                        <textarea v-model="form.excerpt" rows="2" class="w-full rounded-lg border-gray-300"></textarea>

                        <label class="mb-1 mt-4 block text-sm font-medium text-gray-700">เนื้อหา *</label>
                        <RichEditor v-model="form.content" />
                        <p v-if="form.errors.content" class="mt-1 text-sm text-red-600">{{ form.errors.content }}</p>
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <CoverUploader
                            :ratio="16 / 9"
                            :existing="news?.cover"
                            label="รูปปก (16:9)"
                            @update:file="form.cover = $event"
                            @update:remove="form.remove_cover = $event"
                        />
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <GalleryUploader
                            :existing="news?.gallery || []"
                            @update:files="form.gallery = $event"
                            @update:deleted="deletedGallery = $event"
                        />
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <FileAttachments
                            :existing="news?.attachments || []"
                            @update:files="form.attachments = $event"
                            @update:deleted="deletedAttachments = $event"
                        />
                    </div>

                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <LinksRepeater v-model="form.links" />
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-5">
                    <div class="rounded-xl border bg-white p-5 shadow-sm">
                        <label class="mb-2 flex items-center gap-2 text-sm font-medium text-gray-700">
                            <input v-model="form.is_published" type="checkbox" class="rounded" />
                            เผยแพร่
                        </label>

                        <label class="mb-1 mt-3 block text-sm font-medium text-gray-700">วันที่เผยแพร่</label>
                        <input v-model="form.published_at" type="datetime-local" class="w-full rounded-lg border-gray-300 text-sm" />

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
                            {{ isEdit ? 'บันทึกการแก้ไข' : 'สร้างข่าว' }}
                        </button>
                        <Link :href="route('admin.news.index')" class="rounded-lg border px-4 py-2.5 text-center text-sm text-gray-600 hover:bg-gray-50">
                            ยกเลิก
                        </Link>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
