<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    items: { type: Array, default: () => [] },
});

const form = useForm({
    items: props.items.map((i) => ({ ...i })),
});

const dragIndex = ref(null);
const overIndex = ref(null);

const onDragStart = (i) => (dragIndex.value = i);
const onDragOver = (i, e) => {
    e.preventDefault();
    overIndex.value = i;
};
const onDrop = (i) => {
    const from = dragIndex.value;
    dragIndex.value = null;
    overIndex.value = null;
    if (from === null || from === i) return;
    const list = form.items;
    const [moved] = list.splice(from, 1);
    list.splice(i, 0, moved);
};
const onDragEnd = () => {
    dragIndex.value = null;
    overIndex.value = null;
};

const submit = () => {
    form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.menus.update'));
};
</script>

<template>
    <Head title="จัดการเมนู" />
    <AdminLayout>
        <template #title>จัดการเมนูหน้าเว็บ</template>

        <div class="mx-auto max-w-2xl space-y-4">
            <p class="rounded-xl border border-pjs-blue/15 bg-pjs-blue/5 px-4 py-2.5 text-sm text-pjs-blue-dark">
                <i class="bi bi-info-circle"></i> จัดลำดับ เปลี่ยนชื่อ และเปิด/ปิดเมนูที่แสดงบนหน้าเว็บสาธารณะ — ลาก <i class="bi bi-grip-vertical"></i> เพื่อเรียงลำดับ
            </p>

            <form class="space-y-3" @submit.prevent="submit">
                <div class="grid gap-2">
                    <div
                        v-for="(item, i) in form.items"
                        :key="item.key"
                        draggable="true"
                        class="flex items-center gap-3 rounded-xl border bg-white p-3 shadow-sm transition-colors"
                        :class="[
                            dragIndex === i ? 'opacity-40' : '',
                            overIndex === i && dragIndex !== i ? 'ring-1 ring-inset ring-pjs-blue/40' : 'border-slate-100',
                            !item.visible ? 'bg-slate-50' : '',
                        ]"
                        @dragstart="onDragStart(i)"
                        @dragover="onDragOver(i, $event)"
                        @drop="onDrop(i)"
                        @dragend="onDragEnd"
                    >
                        <i class="bi bi-grip-vertical shrink-0 cursor-grab text-slate-300 hover:text-slate-500 active:cursor-grabbing"></i>
                        <span class="w-6 text-center text-sm font-medium text-slate-400">{{ i + 1 }}</span>
                        <input
                            v-model="item.label"
                            type="text"
                            class="min-w-0 flex-1 rounded-lg border-slate-200 text-sm"
                            :class="!item.visible ? 'text-slate-400' : ''"
                        />
                        <label class="flex shrink-0 cursor-pointer items-center gap-1.5 text-xs" :class="item.visible ? 'text-green-600' : 'text-slate-400'">
                            <input v-model="item.visible" type="checkbox" class="rounded" />
                            {{ item.visible ? 'แสดง' : 'ซ่อน' }}
                        </label>
                    </div>
                </div>

                <button type="submit" :disabled="form.processing" class="rounded-lg bg-pjs-blue px-5 py-2.5 text-sm font-medium text-white hover:bg-pjs-blue-dark disabled:opacity-50">
                    บันทึกเมนู
                </button>
            </form>
        </div>
    </AdminLayout>
</template>
