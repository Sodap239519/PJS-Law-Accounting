<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});
</script>

<template>
    <Head title="โปรไฟล์" />

    <AdminLayout>
        <template #title>โปรไฟล์ของฉัน</template>

        <div class="mx-auto max-w-3xl space-y-5">
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                <UpdatePasswordForm />
            </div>
            <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                <DeleteUserForm />
            </div>
        </div>
    </AdminLayout>
</template>
