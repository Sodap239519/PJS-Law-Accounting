<script setup>
import { computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import FloatingSaveBar from '@/Components/Admin/FloatingSaveBar.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import LocalizedFields from '@/Components/Admin/LocalizedFields.vue';

const props = defineProps({
    banner: { type: Object, default: null },
});

const isEdit = computed(() => !!props.banner);

const form = useForm({
    title: props.banner?.title || '',
    subtitle: props.banner?.subtitle || '',
    link_url: props.banner?.link_url || '',
    sort_order: props.banner?.sort_order ?? null,
    is_active: props.banner?.is_active ?? true,
    image: null,
    remove_image: false,
    translations: props.banner?.translations || null,
});

const submit = () => {
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.banners.update', props.banner.id), { forceFormData: true });
    } else {
        form.post(route('admin.banners.store'), { forceFormData: true });
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขแบนเนอร์' : 'เพิ่มแบนเนอร์'" />
    <AdminLayout>
        <template #title>{{ isEdit ? 'แก้ไขแบนเนอร์' : 'เพิ่มแบนเนอร์' }}</template>

        <form class="mx-auto max-w-3xl space-y-6" @submit.prevent="submit">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <CoverUploader
                    :ratio="16 / 9"
                    :existing="banner?.image"
                    label="รูปแบนเนอร์"
                    hint="แนะนำอัตราส่วน 16:9 เพื่อให้เต็มพื้นที่หน้าแรก"
                    @update:file="form.image = $event"
                    @update:remove="form.remove_image = $event"
                />
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <LocalizedFields
                    :form="form"
                    :fields="[
                        { key: 'title', label: 'หัวข้อ' },
                        { key: 'subtitle', label: 'คำโปรย' },
                    ]"
                    v-model:translations="form.translations"
                />

                <label class="field-label mt-4">ลิงก์ปลายทาง (เมื่อคลิกแบนเนอร์)</label>
                <input v-model="form.link_url" type="text" placeholder="https://…" class="field" />
                <p v-if="form.errors.link_url" class="mt-1 text-sm text-red-500">{{ form.errors.link_url }}</p>

                <label class="mb-2 mt-4 flex items-center gap-2 text-sm font-medium text-slate-600">
                    <input v-model="form.is_active" type="checkbox" class="rounded" /> แสดงบนหน้าแรก
                </label>
            </div>

            <div class="flex justify-end gap-2">
                <Link :href="route('admin.banners.index')" class="rounded-lg border px-5 py-2.5 text-center text-sm text-slate-600 hover:bg-slate-50">ยกเลิก</Link>
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    {{ isEdit ? 'บันทึกการแก้ไข' : 'เพิ่มแบนเนอร์' }}
                </button>
            </div>
        </form>

        <FloatingSaveBar :processing="form.processing" @save="submit" @cancel="router.visit(route('admin.banners.index'))" />
    </AdminLayout>
</template>
