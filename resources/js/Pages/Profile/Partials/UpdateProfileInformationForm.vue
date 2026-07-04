<script setup>
import InputError from '@/Components/InputError.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    avatar: null,
    remove_avatar: false,
});

const preview = ref(user.avatar);
const fileInput = ref(null);

const onFile = (e) => {
    const f = e.target.files[0];
    if (!f) return;
    form.avatar = f;
    form.remove_avatar = false;
    preview.value = URL.createObjectURL(f);
    e.target.value = '';
};

const removeAvatar = () => {
    form.avatar = null;
    form.remove_avatar = true;
    preview.value = null;
};

const initials = computed(() => (user.name || '?').trim().charAt(0).toUpperCase());

const submit = () => {
    form
        .transform((d) => ({ ...d, _method: 'patch' }))
        .post(route('profile.update'), { forceFormData: true, preserveScroll: true });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-semibold text-slate-800">ข้อมูลโปรไฟล์</h2>
            <p class="mt-1 text-sm text-slate-500">อัปเดตชื่อ อีเมล และรูปโปรไฟล์ของคุณ</p>
        </header>

        <form class="mt-6 space-y-6" @submit.prevent="submit">
            <!-- Avatar -->
            <div class="flex items-center gap-5">
                <div class="relative h-20 w-20 shrink-0">
                    <img v-if="preview" :src="preview" class="h-20 w-20 rounded-full object-cover ring-4 ring-pjs-blue/10" />
                    <div v-else class="flex h-20 w-20 items-center justify-center rounded-full bg-pjs-blue/10 text-2xl font-bold text-pjs-blue ring-4 ring-pjs-blue/10">
                        {{ initials }}
                    </div>
                </div>
                <div class="space-x-2">
                    <button type="button" class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-50" @click="fileInput.click()">
                        <i class="bi bi-camera mr-1"></i>เปลี่ยนรูป
                    </button>
                    <button v-if="preview" type="button" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-600 hover:bg-red-50" @click="removeAvatar">
                        ลบรูป
                    </button>
                    <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFile" />
                    <p class="mt-1 text-xs text-slate-400">รองรับ JPG, PNG ขนาดไม่เกิน 4MB</p>
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-600">ชื่อ</label>
                <input v-model="form.name" type="text" required autocomplete="name" class="w-full rounded-lg border-slate-300 focus:border-pjs-blue focus:ring-pjs-blue" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-600">อีเมล</label>
                <input v-model="form.email" type="email" required autocomplete="username" class="w-full rounded-lg border-slate-300 focus:border-pjs-blue focus:ring-pjs-blue" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm text-slate-700">
                    อีเมลของคุณยังไม่ได้ยืนยัน
                    <Link :href="route('verification.send')" method="post" as="button" class="text-pjs-blue underline hover:text-pjs-blue-dark">
                        ส่งอีเมลยืนยันอีกครั้ง
                    </Link>
                </p>
                <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                    ส่งลิงก์ยืนยันไปที่อีเมลของคุณแล้ว
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    บันทึก
                </button>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-slate-500">บันทึกแล้ว</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
