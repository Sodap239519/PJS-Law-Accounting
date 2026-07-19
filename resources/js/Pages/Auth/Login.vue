<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="เข้าสู่ระบบ" />

        <div class="overflow-hidden rounded-3xl bg-white shadow-soft">
            <!-- Brand header -->
            <div class="relative bg-gradient-to-br from-pjs-navy via-pjs-blue-dark to-pjs-blue px-8 py-10 text-center text-white">
                <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-white shadow-lg ring-4 ring-white/25">
                    <img src="/frontend/images/PJS-Law-and-Accounting_Logo.png" alt="PJS Law and Accounting" class="h-16 w-16 object-contain" />
                </div>
                <h1 class="text-xl font-bold tracking-wide">PJS Law &amp; Accounting</h1>
                <p class="mt-1 text-sm text-blue-100/80">บริษัท พีเจเอส กฎหมายและการบัญชี จำกัด</p>
                <div class="mx-auto mt-3 h-0.5 w-12 rounded-full bg-amber-300/80"></div>
                <p class="mt-3 text-xs uppercase tracking-[0.2em] text-blue-100/60">ระบบจัดการเว็บไซต์</p>
            </div>

            <form class="space-y-5 px-8 py-8" @submit.prevent="submit">
                <div v-if="status" class="rounded-xl bg-green-50 px-4 py-2 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <!-- Email -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-600">อีเมล</label>
                    <div class="relative">
                        <i class="bi bi-envelope pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="you@example.com"
                            class="w-full rounded-xl border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-slate-700 focus:border-pjs-blue focus:bg-white focus:ring-pjs-blue"
                        />
                    </div>
                    <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-500">{{ form.errors.email }}</p>
                </div>

                <!-- Password -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-600">รหัสผ่าน</label>
                    <div class="relative">
                        <i class="bi bi-lock pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-slate-200 bg-slate-50 py-3 pl-11 pr-11 text-slate-700 focus:border-pjs-blue focus:bg-white focus:ring-pjs-blue"
                        />
                        <button
                            type="button"
                            class="absolute right-3 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-lg text-slate-400 hover:text-pjs-blue"
                            @click="showPassword = !showPassword"
                        >
                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" class="leading-none"></i>
                        </button>
                    </div>
                    <p v-if="form.errors.password" class="mt-1.5 text-sm text-red-500">{{ form.errors.password }}</p>
                </div>

                <!-- session note / forgot -->
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5 text-xs text-slate-400">
                        <i class="bi bi-shield-lock"></i> เข้าสู่ระบบได้นาน 3 วัน
                    </span>
                    <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-pjs-blue hover:underline">
                        ลืมรหัสผ่าน?
                    </Link>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-pjs-blue to-pjs-blue-dark py-3 font-medium text-white shadow-lg shadow-pjs-blue/30 transition hover:opacity-95 disabled:opacity-50"
                >
                    <i class="bi bi-box-arrow-in-right leading-none"></i>
                    {{ form.processing ? 'กำลังเข้าสู่ระบบ...' : 'เข้าสู่ระบบ' }}
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-slate-400">© PJS Law and Accounting Co., Ltd.</p>
    </GuestLayout>
</template>
