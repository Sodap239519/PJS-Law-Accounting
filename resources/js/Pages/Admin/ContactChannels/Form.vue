<script setup>
import { computed, watch } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import FloatingSaveBar from '@/Components/Admin/FloatingSaveBar.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import LocalizedFields from '@/Components/Admin/LocalizedFields.vue';

const props = defineProps({
    channel: { type: Object, default: null },
    types: { type: Object, default: () => ({}) },
});

const isEdit = computed(() => !!props.channel);

const form = useForm({
    type: props.channel?.type || 'phone',
    label: props.channel?.label || '',
    value: props.channel?.value || '',
    icon: props.channel?.icon || '',
    sort_order: props.channel?.sort_order ?? null,
    is_active: props.channel?.is_active ?? true,
    translations: props.channel?.translations || null,
});

// เปลี่ยนประเภท → เติมไอคอนเริ่มต้นให้อัตโนมัติ (เฉพาะตอนเพิ่มใหม่/ยังไม่ตั้งไอคอนเอง)
watch(
    () => form.type,
    (t) => {
        if (!isEdit.value) form.icon = props.types[t]?.icon || '';
    },
    { immediate: true },
);

const valuePlaceholder = computed(() => {
    const map = {
        phone: '02-xxx-xxxx',
        email: 'contact@pjs-law.com',
        line: '@pjslaw หรือ ลิงก์ LINE',
        facebook: 'ลิงก์เพจ Facebook',
        instagram: 'ลิงก์ / @ชื่อผู้ใช้',
        tiktok: 'ลิงก์ / @ชื่อผู้ใช้',
        youtube: 'ลิงก์ช่อง YouTube',
        address: 'ที่อยู่บริษัท',
        map: 'ลิงก์ Google Maps',
    };
    return map[form.type] || '';
});

const submit = () => {
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.contact-channels.update', props.channel.id));
    } else {
        form.post(route('admin.contact-channels.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขช่องทางติดต่อ' : 'เพิ่มช่องทางติดต่อ'" />
    <AdminLayout>
        <template #title>{{ isEdit ? 'แก้ไขช่องทางติดต่อ' : 'เพิ่มช่องทางติดต่อ' }}</template>

        <form class="mx-auto max-w-2xl space-y-6" @submit.prevent="submit">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-1 block text-sm font-medium text-slate-600">ประเภท *</label>
                <div class="grid grid-cols-3 gap-2 sm:grid-cols-3">
                    <button
                        v-for="(t, key) in types"
                        :key="key"
                        type="button"
                        class="flex items-center gap-2 rounded-lg border px-3 py-2 text-sm transition"
                        :class="form.type === key ? 'border-pjs-blue bg-pjs-blue/5 text-pjs-blue' : 'border-slate-200 text-slate-500 hover:bg-slate-50'"
                        @click="form.type = key"
                    >
                        <i :class="t.icon"></i> {{ t.label }}
                    </button>
                </div>

                <label class="mb-1 mt-5 block text-sm font-medium text-slate-600">ค่า / ข้อมูล *</label>
                <input v-model="form.value" type="text" :placeholder="valuePlaceholder" class="w-full rounded-lg border-slate-200" />
                <p v-if="form.errors.value" class="mt-1 text-sm text-red-500">{{ form.errors.value }}</p>

                <div class="mt-5">
                    <LocalizedFields
                        :form="form"
                        :fields="[{ key: 'label', label: 'ป้ายกำกับ (ไม่ใส่ก็ได้)', placeholder: 'เช่น สายด่วน, ฝ่ายบัญชี' }]"
                        v-model:translations="form.translations"
                    />
                </div>

                <div class="mt-4">
                    <label class="field-label">ไอคอน <i :class="form.icon" class="ml-1 text-pjs-blue"></i></label>
                    <input v-model="form.icon" type="text" placeholder="bi bi-telephone" class="field" />
                </div>

                <label class="mb-2 mt-4 flex items-center gap-2 text-sm font-medium text-slate-600">
                    <input v-model="form.is_active" type="checkbox" class="rounded" /> แสดงบนหน้าเว็บ
                </label>
            </div>

            <div class="flex justify-end gap-2">
                <Link :href="route('admin.contact-channels.index')" class="rounded-lg border px-5 py-2.5 text-center text-sm text-slate-600 hover:bg-slate-50">ยกเลิก</Link>
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    {{ isEdit ? 'บันทึกการแก้ไข' : 'เพิ่มช่องทาง' }}
                </button>
            </div>
        </form>

        <FloatingSaveBar :processing="form.processing" @save="submit" @cancel="router.visit(route('admin.contact-channels.index'))" />
    </AdminLayout>
</template>
