<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    items: { type: Array, default: () => [] },
});

const form = useForm({
    items: props.items.map((i) => ({
        ...i,
        children: (i.children || []).map((c) => ({ ...c })),
    })),
});

// ---- drag เมนูหลัก ----
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

// ---- drag เมนูย่อย (ภายใน parent เดียวกัน) ----
const cDrag = ref(null);
const cOver = ref(null);
const onChildDragStart = (p, i) => (cDrag.value = { p, i });
const onChildDragOver = (p, i, e) => {
    e.preventDefault();
    cOver.value = { p, i };
};
const onChildDrop = (p, i) => {
    const d = cDrag.value;
    cDrag.value = null;
    cOver.value = null;
    if (!d || d.p !== p || d.i === i) return;
    const list = form.items[p].children;
    const [m] = list.splice(d.i, 1);
    list.splice(i, 0, m);
};
const onChildDragEnd = () => {
    cDrag.value = null;
    cOver.value = null;
};

const addChild = (item) => {
    if (!item.children) item.children = [];
    item.children.push({ label: '', url: '', visible: true });
};
const removeChild = (item, ci) => item.children.splice(ci, 1);

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
                <i class="bi bi-info-circle"></i> จัดลำดับ เปลี่ยนชื่อ เปิด/ปิด และเพิ่ม<strong>เมนูย่อย</strong>ได้ — ลาก <i class="bi bi-grip-vertical"></i> เพื่อเรียงลำดับ
            </p>

            <form class="space-y-3" @submit.prevent="submit">
                <div class="grid gap-2">
                    <div
                        v-for="(item, i) in form.items"
                        :key="item.key"
                        class="overflow-hidden rounded-xl border bg-white shadow-sm transition-colors"
                        :class="[overIndex === i && dragIndex !== i ? 'ring-1 ring-inset ring-pjs-blue/40' : 'border-slate-100', dragIndex === i ? 'opacity-40' : '']"
                    >
                        <!-- เมนูหลัก -->
                        <div
                            draggable="true"
                            class="flex items-center gap-3 p-3"
                            :class="!item.visible ? 'bg-slate-50' : ''"
                            @dragstart="onDragStart(i)"
                            @dragover="onDragOver(i, $event)"
                            @drop="onDrop(i)"
                            @dragend="onDragEnd"
                        >
                            <i class="bi bi-grip-vertical shrink-0 cursor-grab text-slate-300 hover:text-slate-500 active:cursor-grabbing"></i>
                            <span class="w-6 text-center text-sm font-medium text-slate-400">{{ i + 1 }}</span>
                            <input v-model="item.label" type="text" class="min-w-0 flex-1 rounded-lg border-slate-200 text-sm" :class="!item.visible ? 'text-slate-400' : ''" />
                            <label class="flex shrink-0 cursor-pointer items-center gap-1.5 text-xs" :class="item.visible ? 'text-green-600' : 'text-slate-400'">
                                <input v-model="item.visible" type="checkbox" class="rounded" />
                                {{ item.visible ? 'แสดง' : 'ซ่อน' }}
                            </label>
                        </div>

                        <!-- เมนูย่อย -->
                        <div class="border-t border-slate-100 bg-slate-50/60 py-2 pl-10 pr-3">
                            <p class="mb-1.5 text-[11px] font-medium text-slate-400">เมนูย่อย (dropdown)</p>

                            <div
                                v-for="(c, ci) in item.children"
                                :key="ci"
                                draggable="true"
                                class="mb-1.5 flex items-center gap-1.5 rounded-lg border bg-white p-1.5 transition-colors"
                                :class="cOver && cOver.p === i && cOver.i === ci && !(cDrag && cDrag.i === ci) ? 'ring-1 ring-inset ring-pjs-blue/40' : 'border-slate-100'"
                                @dragstart="onChildDragStart(i, ci)"
                                @dragover="onChildDragOver(i, ci, $event)"
                                @drop="onChildDrop(i, ci)"
                                @dragend="onChildDragEnd"
                            >
                                <i class="bi bi-grip-vertical shrink-0 cursor-grab text-slate-300 active:cursor-grabbing"></i>
                                <input v-model="c.label" type="text" placeholder="ชื่อเมนูย่อย" class="w-32 shrink-0 rounded-md border-slate-200 text-xs" />
                                <input v-model="c.url" type="text" placeholder="ลิงก์ เช่น /services/xxx หรือ https://…" class="min-w-0 flex-1 rounded-md border-slate-200 text-xs" />
                                <label class="flex shrink-0 cursor-pointer items-center gap-1 text-[11px]" :class="c.visible ? 'text-green-600' : 'text-slate-400'">
                                    <input v-model="c.visible" type="checkbox" class="rounded" />
                                    {{ c.visible ? 'แสดง' : 'ซ่อน' }}
                                </label>
                                <button type="button" class="shrink-0 px-1 text-red-400 hover:text-red-600" @click="removeChild(item, ci)"><i class="bi bi-x-lg text-xs"></i></button>
                            </div>

                            <button type="button" class="rounded-lg border border-dashed border-slate-300 px-2.5 py-1 text-xs text-slate-500 hover:border-pjs-blue hover:text-pjs-blue" @click="addChild(item)">
                                <i class="bi bi-plus"></i> เพิ่มเมนูย่อย
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" :disabled="form.processing" class="btn-primary">บันทึกเมนู</button>
            </form>
        </div>
    </AdminLayout>
</template>
