<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';
import GalleryUploader from '@/Components/Admin/GalleryUploader.vue';

const props = defineProps({
    about: { type: Object, default: () => ({}) },
    layouts: { type: Object, default: () => ({}) },
});

const deletedGallery = ref([]);

const form = useForm({
    layout: props.about.layout || 'layout1',
    content: props.about.content || '',
    gallery: [],
    deleted_media: [],
});

const submit = () => {
    form.deleted_media = deletedGallery.value;
    form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.about.update'), { forceFormData: true });
};
</script>

<template>
    <Head title="เกี่ยวกับเรา" />
    <AdminLayout>
        <template #title>หน้าเกี่ยวกับเรา</template>

        <form class="mx-auto max-w-3xl space-y-6" @submit.prevent="submit">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-2 block text-sm font-medium text-slate-600">รูปแบบการจัดวาง (Layout)</label>
                <div class="grid gap-2 sm:grid-cols-3">
                    <button
                        v-for="(label, key) in layouts"
                        :key="key"
                        type="button"
                        class="rounded-xl border p-3 text-left text-sm transition"
                        :class="form.layout === key ? 'border-pjs-blue bg-pjs-blue/5 text-pjs-blue' : 'border-slate-200 text-slate-500 hover:bg-slate-50'"
                        @click="form.layout = key"
                    >
                        <i :class="form.layout === key ? 'bi bi-check-circle-fill' : 'bi bi-circle'" class="mb-1 block"></i>
                        {{ label }}
                    </button>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-1 block text-sm font-medium text-slate-600">เนื้อหา</label>
                <RichEditor v-model="form.content" />
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <GalleryUploader
                    :existing="about.gallery || []"
                    label="รูปประกอบ (แกลเลอรี)"
                    @update:files="form.gallery = $event"
                    @update:deleted="deletedGallery = $event"
                />
            </div>

            <div>
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    บันทึกหน้าเกี่ยวกับเรา
                </button>
            </div>
        </form>
    </AdminLayout>
</template>
