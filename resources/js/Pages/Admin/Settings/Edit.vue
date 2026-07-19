<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import FloatingSaveBar from '@/Components/Admin/FloatingSaveBar.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    settings: { type: Object, default: () => ({}) },
});

const logoPreview = ref(props.settings.logo || null);
const faviconPreview = ref(props.settings.favicon || null);

const form = useForm({
    site_name: props.settings.site_name || '',
    tagline: props.settings.tagline || '',
    logo: null,
    favicon: null,
    remove_logo: false,
    remove_favicon: false,
});

const onImage = (e, field) => {
    const f = e.target.files[0];
    if (!f) return;
    form[field] = f;
    form['remove_' + field] = false;
    const url = URL.createObjectURL(f);
    if (field === 'logo') logoPreview.value = url;
    else faviconPreview.value = url;
    e.target.value = '';
};

const clearImage = (field) => {
    form[field] = null;
    form['remove_' + field] = true;
    if (field === 'logo') logoPreview.value = null;
    else faviconPreview.value = null;
};

const submit = () => {
    form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.settings.update'), { forceFormData: true });
};
</script>

<template>
    <Head title="ตั้งค่าโลโก้/ชื่อเว็บ" />
    <AdminLayout>
        <template #title>ตั้งค่าโลโก้ / ชื่อเว็บ</template>

        <form class="mx-auto max-w-2xl space-y-6" @submit.prevent="submit">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-1 block text-sm font-medium text-slate-600">ชื่อเว็บไซต์ *</label>
                <input v-model="form.site_name" type="text" class="w-full rounded-lg border-slate-200" />
                <p v-if="form.errors.site_name" class="mt-1 text-sm text-red-500">{{ form.errors.site_name }}</p>

                <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">คำโปรย (Tagline)</label>
                <input v-model="form.tagline" type="text" placeholder="เช่น ที่ปรึกษากฎหมายและบัญชีครบวงจร" class="w-full rounded-lg border-slate-200" />
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <!-- Logo -->
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <label class="mb-2 block text-sm font-medium text-slate-600">โลโก้เว็บไซต์</label>
                    <div class="flex h-24 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 p-2">
                        <img v-if="logoPreview" :src="logoPreview" class="max-h-full max-w-full object-contain" />
                        <span v-else class="text-xs text-slate-400">ยังไม่มีโลโก้</span>
                    </div>
                    <div class="mt-2 flex gap-2">
                        <label class="cursor-pointer rounded-lg border px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">
                            เลือกรูป
                            <input type="file" accept="image/*" class="hidden" @change="(e) => onImage(e, 'logo')" />
                        </label>
                        <button v-if="logoPreview" type="button" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-500 hover:bg-red-50" @click="clearImage('logo')">ลบ</button>
                    </div>
                    <p v-if="form.errors.logo" class="mt-1 text-sm text-red-500">{{ form.errors.logo }}</p>
                </div>

                <!-- Favicon -->
                <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                    <label class="mb-2 block text-sm font-medium text-slate-600">Favicon <span class="text-xs font-normal text-slate-400">(ไอคอนแท็บเบราว์เซอร์)</span></label>
                    <div class="flex h-24 items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50 p-2">
                        <img v-if="faviconPreview" :src="faviconPreview" class="h-12 w-12 rounded object-contain" />
                        <span v-else class="text-xs text-slate-400">ยังไม่มี favicon</span>
                    </div>
                    <div class="mt-2 flex gap-2">
                        <label class="cursor-pointer rounded-lg border px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">
                            เลือกรูป
                            <input type="file" accept="image/*" class="hidden" @change="(e) => onImage(e, 'favicon')" />
                        </label>
                        <button v-if="faviconPreview" type="button" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-500 hover:bg-red-50" @click="clearImage('favicon')">ลบ</button>
                    </div>
                    <p v-if="form.errors.favicon" class="mt-1 text-sm text-red-500">{{ form.errors.favicon }}</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    บันทึกการตั้งค่า
                </button>
            </div>
        </form>

        <FloatingSaveBar :processing="form.processing" :cancel-label="'ล้างการแก้ไข'" @save="submit" @cancel="form.reset()" />
    </AdminLayout>
</template>
