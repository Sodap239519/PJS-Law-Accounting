<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    user: { type: Object, default: null },
    roles: { type: Object, default: () => ({}) },
});

const isEdit = computed(() => !!props.user);

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    password: '',
    password_confirmation: '',
    role: props.user?.role || 'admin',
});

const submit = () => {
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.users.update', props.user.id));
    } else {
        form.post(route('admin.users.store'));
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขผู้ใช้' : 'เพิ่มผู้ใช้'" />
    <AdminLayout>
        <template #title>{{ isEdit ? 'แก้ไขผู้ใช้' : 'เพิ่มผู้ใช้' }}</template>

        <form class="mx-auto max-w-lg space-y-6" @submit.prevent="submit">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-1 block text-sm font-medium text-slate-600">ชื่อ *</label>
                <input v-model="form.name" type="text" class="w-full rounded-lg border-slate-200" />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</p>

                <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">อีเมล *</label>
                <input v-model="form.email" type="email" class="w-full rounded-lg border-slate-200" />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</p>

                <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">สิทธิ์การใช้งาน *</label>
                <div class="grid grid-cols-2 gap-2">
                    <button
                        v-for="(label, key) in roles"
                        :key="key"
                        type="button"
                        class="flex items-center gap-2 rounded-lg border px-3 py-2 text-sm transition"
                        :class="form.role === key ? 'border-pjs-blue bg-pjs-blue/5 text-pjs-blue' : 'border-slate-200 text-slate-500 hover:bg-slate-50'"
                        @click="form.role = key"
                    >
                        <i :class="key === 'super_admin' ? 'bi bi-shield-check' : 'bi bi-person-badge'"></i> {{ label }}
                    </button>
                </div>
                <p class="mt-1.5 text-xs text-slate-400">ผู้ดูแลระบบสูงสุดจัดการผู้ใช้และเมนูได้ ผู้ดูแลระบบทั่วไปจัดการเนื้อหาได้</p>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-1 block text-sm font-medium text-slate-600">
                    รหัสผ่าน <span v-if="isEdit" class="text-xs font-normal text-slate-400">(เว้นว่างหากไม่เปลี่ยน)</span><span v-else> *</span>
                </label>
                <input v-model="form.password" type="password" autocomplete="new-password" class="w-full rounded-lg border-slate-200" />
                <p v-if="form.errors.password" class="mt-1 text-sm text-red-500">{{ form.errors.password }}</p>

                <label class="mb-1 mt-4 block text-sm font-medium text-slate-600">ยืนยันรหัสผ่าน</label>
                <input v-model="form.password_confirmation" type="password" autocomplete="new-password" class="w-full rounded-lg border-slate-200" />
            </div>

            <div class="flex justify-end gap-2">
                <Link :href="route('admin.users.index')" class="rounded-lg border px-5 py-2.5 text-center text-sm text-slate-600 hover:bg-slate-50">ยกเลิก</Link>
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    {{ isEdit ? 'บันทึกการแก้ไข' : 'เพิ่มผู้ใช้' }}
                </button>
            </div>
        </form>
    </AdminLayout>
</template>
