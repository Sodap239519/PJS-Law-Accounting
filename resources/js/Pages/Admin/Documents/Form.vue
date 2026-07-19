<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import FloatingSaveBar from '@/Components/Admin/FloatingSaveBar.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import LocalizedFields from '@/Components/Admin/LocalizedFields.vue';

const props = defineProps({
    document: { type: Object, default: null },
    categories: { type: Array, default: () => [] },
});

const isEdit = computed(() => !!props.document);
const fileName = ref('');

const form = useForm({
    title: props.document?.title || '',
    description: props.document?.description || '',
    category_id: props.document?.category_id || null,
    is_active: props.document?.is_active ?? true,
    file: null,
    remove_file: false,
    translations: props.document?.translations || null,
});

const onFile = (e) => {
    const f = e.target.files[0];
    form.file = f || null;
    fileName.value = f?.name || '';
    if (f) form.remove_file = false;
};

const submit = () => {
    if (isEdit.value) {
        form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.documents.update', props.document.id), { forceFormData: true });
    } else {
        form.post(route('admin.documents.store'), { forceFormData: true });
    }
};
</script>

<template>
    <Head :title="isEdit ? 'แก้ไขเอกสาร' : 'เพิ่มเอกสาร'" />
    <AdminLayout>
        <template #title>{{ isEdit ? 'แก้ไขเอกสาร' : 'เพิ่มเอกสาร' }}</template>

        <form class="mx-auto max-w-2xl space-y-6" @submit.prevent="submit">
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <LocalizedFields
                    :form="form"
                    :fields="[
                        { key: 'title', label: 'ชื่อเอกสาร', required: true },
                        { key: 'description', label: 'คำอธิบาย', type: 'textarea', rows: 3 },
                    ]"
                    v-model:translations="form.translations"
                />

                <label class="field-label mt-4">หมวดหมู่</label>
                <select v-model="form.category_id" class="w-full rounded-lg border-slate-200 text-sm">
                    <option :value="null">— ไม่ระบุ —</option>
                    <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                </select>

                <label class="mb-2 mt-4 flex items-center gap-2 text-sm font-medium text-slate-600">
                    <input v-model="form.is_active" type="checkbox" class="rounded" /> เผยแพร่ให้ดาวน์โหลด
                </label>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                <label class="mb-2 block text-sm font-medium text-slate-600">ไฟล์เอกสาร (PDF, Word, Excel, PPT, รูป)</label>
                <div v-if="document?.file && !form.file && !form.remove_file" class="mb-2 flex items-center gap-2 rounded-lg border bg-slate-50 px-3 py-2 text-sm">
                    <span>📎</span>
                    <a :href="document.file.url" target="_blank" class="flex-1 truncate text-pjs-blue hover:underline">{{ document.file.name }}</a>
                    <span class="text-xs text-slate-400">{{ document.file.size }}</span>
                    <button type="button" class="text-red-500 hover:text-red-700" @click="form.remove_file = true">✕</button>
                </div>
                <input type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,image/*" class="block w-full text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-pjs-blue/10 file:px-4 file:py-2 file:text-sm file:text-pjs-blue hover:file:bg-pjs-blue/20" @change="onFile" />
                <p v-if="fileName" class="mt-1 text-xs text-pjs-blue">เลือกไฟล์ใหม่: {{ fileName }}</p>
                <p v-if="form.errors.file" class="mt-1 text-sm text-red-500">{{ form.errors.file }}</p>
            </div>

            <div class="flex justify-end gap-2">
                <Link :href="route('admin.documents.index')" class="rounded-lg border px-5 py-2.5 text-center text-sm text-slate-600 hover:bg-slate-50">ยกเลิก</Link>
                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    {{ isEdit ? 'บันทึกการแก้ไข' : 'เพิ่มเอกสาร' }}
                </button>
            </div>
        </form>

        <FloatingSaveBar :processing="form.processing" @save="submit" @cancel="router.visit(route('admin.documents.index'))" />
    </AdminLayout>
</template>
