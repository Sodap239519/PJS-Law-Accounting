<script setup>
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    types: { type: Object, default: () => ({}) },
    categories: { type: Object, default: () => ({}) },
});

const items = ref({});
const draft = ref({}); // ชื่อหมวดหมู่ใหม่ต่อประเภท

const sync = () => {
    const o = {};
    for (const t of Object.keys(props.types)) {
        o[t] = (props.categories[t] || []).map((c) => ({ ...c }));
    }
    items.value = o;
};
sync();
watch(() => props.categories, sync, { deep: true });

const add = (type) => {
    const name = (draft.value[type] || '').trim();
    if (!name) return;
    router.post(route('admin.categories.store'), { name, type }, {
        preserveScroll: true,
        onSuccess: () => (draft.value[type] = ''),
    });
};

const save = (cat) => {
    router.put(route('admin.categories.update', cat.id), { name: cat.name, is_active: cat.is_active }, { preserveScroll: true });
};

const remove = (cat) => {
    if (confirm(`ลบหมวดหมู่ "${cat.name}"? (เนื้อหาที่ใช้หมวดนี้จะไม่ถูกลบ แต่หมวดหมู่จะหายไป)`)) {
        router.delete(route('admin.categories.destroy', cat.id), { preserveScroll: true });
    }
};

const icon = { news: 'bi bi-newspaper', announcement: 'bi bi-megaphone', case_study: 'bi bi-bank', document: 'bi bi-file-earmark-text' };
</script>

<template>
    <Head title="จัดการหมวดหมู่" />
    <AdminLayout>
        <template #title>จัดการหมวดหมู่</template>

        <p class="mb-4 rounded-xl border border-pjs-blue/15 bg-pjs-blue/5 px-4 py-2.5 text-sm text-pjs-blue-dark">
            <i class="bi bi-info-circle"></i> หมวดหมู่ใช้จัดกลุ่มเนื้อหาแต่ละประเภท — เพิ่ม/แก้ชื่อ/เปิด-ปิด ได้ที่นี่ (หมวดที่ปิดจะไม่ให้เลือกในฟอร์ม)
        </p>

        <div class="grid gap-5 lg:grid-cols-2">
            <div v-for="(label, type) in types" :key="type" class="pjs-card p-5">
                <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <i :class="icon[type]" class="text-pjs-blue/70"></i> หมวดหมู่{{ label }}
                    <span class="ml-auto rounded-full bg-slate-100 px-2 py-0.5 text-xs font-normal text-slate-500">{{ (items[type] || []).length }}</span>
                </h3>

                <div class="space-y-2">
                    <div v-for="cat in items[type]" :key="cat.id" class="flex items-center gap-2">
                        <input v-model="cat.name" type="text" class="field" :class="!cat.is_active ? 'text-slate-400' : ''" @blur="save(cat)" @keyup.enter="save(cat)" />
                        <label class="flex shrink-0 cursor-pointer items-center gap-1 text-xs" :class="cat.is_active ? 'text-green-600' : 'text-slate-400'">
                            <input v-model="cat.is_active" type="checkbox" class="rounded" @change="save(cat)" />
                            {{ cat.is_active ? 'ใช้' : 'ปิด' }}
                        </label>
                        <button type="button" class="shrink-0 px-1 text-red-400 hover:text-red-600" @click="remove(cat)"><i class="bi bi-trash"></i></button>
                    </div>

                    <p v-if="!(items[type] || []).length" class="py-2 text-center text-xs text-slate-400">ยังไม่มีหมวดหมู่</p>
                </div>

                <div class="mt-3 flex items-center gap-2 border-t border-slate-100 pt-3">
                    <input v-model="draft[type]" type="text" placeholder="ชื่อหมวดหมู่ใหม่…" class="field" @keyup.enter="add(type)" />
                    <button type="button" class="btn-primary btn-sm shrink-0" @click="add(type)"><i class="bi bi-plus-lg"></i> เพิ่ม</button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
