<script setup>
import { ref, computed, watch, onBeforeUnmount } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichEditor from '@/Components/Admin/RichEditor.vue';
import GalleryUploader from '@/Components/Admin/GalleryUploader.vue';

const props = defineProps({
    about: { type: Object, default: () => ({}) },
    layouts: { type: Object, default: () => ({}) },
});

const deletedGallery = ref([]);

const form = useForm({
    layout: props.about.layout || 'layout1',
    content: props.about.content || '',
    gallery: [],
    deleted_media: [],
});

// URL พรีวิวของรูปใหม่ (สร้าง object URL จากไฟล์ที่เลือก)
const newPreviews = ref([]);
watch(
    () => form.gallery,
    (files) => {
        newPreviews.value.forEach((u) => URL.revokeObjectURL(u));
        newPreviews.value = (files || []).map((f) => URL.createObjectURL(f));
    },
    { deep: true },
);
onBeforeUnmount(() => newPreviews.value.forEach((u) => URL.revokeObjectURL(u)));

// รูปทั้งหมดสำหรับพรีวิว = รูปเดิม (ที่ยังไม่ลบ) + รูปใหม่
const galleryPreview = computed(() => {
    const existing = (props.about.gallery || [])
        .filter((g) => !deletedGallery.value.includes(g.id))
        .map((g) => g.url);
    return [...existing, ...newPreviews.value];
});

const hasContent = computed(() => form.content && form.content.replace(/<[^>]*>/g, '').trim().length > 0);

const submit = () => {
    form.deleted_media = deletedGallery.value;
    form.transform((d) => ({ ...d, _method: 'put' })).post(route('admin.about.update'), { forceFormData: true });
};
</script>

<template>
    <Head title="เกี่ยวกับเรา" />
    <AdminLayout>
        <form class="space-y-6" @submit.prevent="submit">
            <!-- Title + save (same row) -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-lg font-semibold text-slate-800">หน้าเกี่ยวกับเรา</h1>
                <div class="pjs-card flex items-center gap-2 py-2 pl-4 pr-2">
                    <Link :href="route('admin.dashboard')" class="btn-outline btn-sm">ยกเลิก</Link>
                    <button type="submit" :disabled="form.processing" class="btn-primary btn-sm">บันทึก</button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- LEFT: content + gallery -->
                <div class="space-y-5 lg:col-span-2">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <label class="mb-1 block text-sm font-medium text-slate-600">เนื้อหา</label>
                        <RichEditor v-model="form.content" :height="620" />
                    </div>

                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 flex items-center gap-2 text-sm font-semibold text-slate-700"><i class="bi bi-images text-pjs-blue/70"></i> รูปประกอบ (แกลเลอรี)</h3>
                        <GalleryUploader
                            :existing="about.gallery || []"
                            label=""
                            @update:files="form.gallery = $event"
                            @update:deleted="deletedGallery = $event"
                        />
                    </div>
                </div>

                <!-- RIGHT: layout selector + live preview -->
                <div class="space-y-5">
                    <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
                        <label class="mb-2 block text-sm font-medium text-slate-600">รูปแบบการจัดวาง (Layout)</label>
                        <div class="space-y-2">
                            <button
                                v-for="(label, key) in layouts"
                                :key="key"
                                type="button"
                                class="flex w-full items-start gap-2 rounded-xl border p-3 text-left text-sm transition"
                                :class="form.layout === key ? 'border-pjs-blue bg-pjs-blue/5 text-pjs-blue' : 'border-slate-200 text-slate-500 hover:bg-slate-50'"
                                @click="form.layout = key"
                            >
                                <i :class="form.layout === key ? 'bi bi-check-circle-fill' : 'bi bi-circle'" class="mt-0.5"></i>
                                <span>{{ label }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Live preview -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-sm">
                        <p class="mb-2 flex items-center gap-1.5 text-xs font-semibold text-slate-500"><i class="bi bi-eye text-pjs-blue/70"></i> ตัวอย่างการแสดงผล</p>
                        <div class="overflow-hidden rounded-xl border border-slate-100 bg-slate-50 p-3">
                            <!-- layout1: ข้อความเต็มความกว้าง -->
                            <div v-if="form.layout === 'layout1'" class="space-y-3">
                                <div v-if="hasContent" class="prose prose-sm max-w-none text-slate-700" v-html="form.content"></div>
                                <p v-else class="py-6 text-center text-xs text-slate-400">— ยังไม่มีเนื้อหา —</p>
                                <div v-if="galleryPreview.length" class="grid grid-cols-3 gap-1.5">
                                    <img v-for="(img, i) in galleryPreview" :key="i" :src="img" class="aspect-square w-full rounded-md object-cover" />
                                </div>
                            </div>

                            <!-- layout2: รูปซ้าย + ข้อความขวา -->
                            <div v-else-if="form.layout === 'layout2'" class="flex gap-3">
                                <div class="w-2/5 shrink-0">
                                    <img v-if="galleryPreview[0]" :src="galleryPreview[0]" class="aspect-[3/4] w-full rounded-md object-cover" />
                                    <div v-else class="flex aspect-[3/4] w-full items-center justify-center rounded-md bg-slate-200 text-slate-400"><i class="bi bi-image"></i></div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div v-if="hasContent" class="prose prose-sm max-w-none text-slate-700" v-html="form.content"></div>
                                    <p v-else class="text-xs text-slate-400">— ยังไม่มีเนื้อหา —</p>
                                </div>
                            </div>

                            <!-- layout3: ข้อความบน + แกลเลอรีล่าง -->
                            <div v-else class="space-y-3">
                                <div v-if="hasContent" class="prose prose-sm max-w-none text-slate-700" v-html="form.content"></div>
                                <p v-else class="text-center text-xs text-slate-400">— ยังไม่มีเนื้อหา —</p>
                                <div v-if="galleryPreview.length" class="grid grid-cols-4 gap-1.5">
                                    <img v-for="(img, i) in galleryPreview" :key="i" :src="img" class="aspect-square w-full rounded-md object-cover" />
                                </div>
                                <div v-else class="flex h-16 items-center justify-center rounded-md bg-slate-200 text-slate-400"><i class="bi bi-images"></i></div>
                            </div>
                        </div>
                        <p class="mt-2 text-[11px] text-slate-400">ตัวอย่างจะอัปเดตอัตโนมัติเมื่อพิมพ์เนื้อหาหรือเพิ่มรูป</p>
                    </div>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
