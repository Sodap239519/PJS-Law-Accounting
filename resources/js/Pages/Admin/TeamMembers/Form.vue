<script setup>
import { computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import FloatingSaveBar from '@/Components/Admin/FloatingSaveBar.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';
import CoverUploader from '@/Components/Admin/CoverUploader.vue';
import LocalizedFields from '@/Components/Admin/LocalizedFields.vue';

const props = defineProps({
    member: { type: Object, default: null },
});

const isEdit = computed(() => !!props.member);

const form = useForm({
    name: props.member?.name || '',
    position: props.member?.position || '',
    bio: props.member?.bio || '',
    socials: {
        facebook: props.member?.socials?.facebook || '',
        line: props.member?.socials?.line || '',
        email: props.member?.socials?.email || '',
        phone: props.member?.socials?.phone || '',
    },
    order: props.member?.order ?? null,
    is_active: props.member?.is_active ?? true,
    photo: null,
    remove_photo: false,
    translations: props.member?.translations || null,
});

const socialFields = [
    { key: 'facebook', label: 'Facebook', icon: 'bi bi-facebook', placeholder: 'ลิงก์โปรไฟล์ Facebook' },
    { key: 'line', label: 'LINE', icon: 'bi bi-line', placeholder: 'LINE ID หรือลิงก์' },
    { key: 'email', label: 'อีเมล', icon: 'bi bi-envelope', placeholder: 'name@example.com' },
    { key: 'phone', label: 'โทรศัพท์', icon: 'bi bi-telephone', placeholder: '08x-xxx-xxxx' },
];

const submit = () => {
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.team-members.update', props.member.id), { forceFormData: true });
    } else {
        form.post(route('admin.team-members.store'), { forceFormData: true });
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขบุคลากร' : 'เพิ่มบุคลากร'" />
    <AdminLayout>
        <template #title>{{ isEdit ? 'แก้ไขบุคลากร' : 'เพิ่มบุคลากร' }}</template>

        <form class="mx-auto max-w-4xl space-y-6" @submit.prevent="submit">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="space-y-5 lg:col-span-2">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <LocalizedFields
                            :form="form"
                            :fields="[
                                { key: 'name', label: 'ชื่อ-นามสกุล', required: true },
                                { key: 'position', label: 'ตำแหน่ง', required: true },
                            ]"
                            v-model:translations="form.translations"
                        />

                        <label class="field-label mt-4">ประวัติ / ความเชี่ยวชาญ</label>
                        <RichEditor v-model="form.bio" />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 text-sm font-semibold text-slate-700">ช่องทางติดต่อ</h3>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <div v-for="f in socialFields" :key="f.key">
                                <label class="mb-1 flex items-center gap-1.5 text-xs font-medium text-slate-500"><i :class="f.icon" class="text-pjs-blue/70"></i>{{ f.label }}</label>
                                <input v-model="form.socials[f.key]" type="text" :placeholder="f.placeholder" class="w-full rounded-lg border-slate-200 text-sm" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <CoverUploader
                            :ratio="4 / 5"
                            :existing="member?.photo"
                            label="รูปภาพ"
                            @update:file="form.photo = $event"
                            @update:remove="form.remove_photo = $event"
                        />
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <p class="mb-2 flex items-center gap-1.5 text-xs text-slate-400"><i class="bi bi-info-circle"></i> ลำดับอัตโนมัติ — ลากจัดลำดับได้ในหน้ารายการ</p>
                        <label class="mb-2 flex items-center gap-2 text-sm font-medium text-slate-600">
                            <input v-model="form.is_active" type="checkbox" class="rounded" /> แสดงบนหน้าเว็บ
                        </label>
                    </div>
                    <div class="flex flex-col gap-2">
                        <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-4 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                            {{ isEdit ? 'บันทึกการแก้ไข' : 'เพิ่มบุคลากร' }}
                        </button>
                        <Link :href="route('admin.team-members.index')" class="rounded-lg border px-4 py-2.5 text-center text-sm text-slate-600 hover:bg-slate-50">ยกเลิก</Link>
                    </div>
                </div>
            </div>
        </form>

        <FloatingSaveBar :processing="form.processing" @save="submit" @cancel="router.visit(route('admin.team-members.index'))" />
    </AdminLayout>
</template>
