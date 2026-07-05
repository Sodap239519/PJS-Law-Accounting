<script setup>
import { ref, computed } from 'vue';
import { Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

const props = defineProps({
    existing: { type: Object, default: null }, // { id, url, name }
    ratio: { type: Number, default: 16 / 9 },
    label: { type: String, default: 'รูปปก' },
    hint: { type: String, default: '' },
    card: { type: Boolean, default: false }, // สไตล์การ์ดรูปเต็ม (เหมือนการ์ดโปรไฟล์)
});
const emit = defineEmits(['update:file', 'update:remove']);

const rawImage = ref(null);
const croppedUrl = ref(null);
const removed = ref(false);
const cropperRef = ref(null);
const inputRef = ref(null);

const onSelect = (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = () => (rawImage.value = reader.result);
    reader.readAsDataURL(file);
    e.target.value = '';
};

const confirmCrop = () => {
    const result = cropperRef.value?.getResult();
    if (!result?.canvas) return;
    result.canvas.toBlob(
        (blob) => {
            croppedUrl.value = URL.createObjectURL(blob);
            emit('update:file', new File([blob], 'cover.jpg', { type: 'image/jpeg' }));
            emit('update:remove', false);
            removed.value = false;
            rawImage.value = null;
        },
        'image/jpeg',
        0.9,
    );
};

const clearImage = () => {
    croppedUrl.value = null;
    removed.value = true;
    emit('update:file', null);
    emit('update:remove', true);
};

const preview = computed(() => croppedUrl.value || (!removed.value ? props.existing?.url : null) || null);
const boxStyle = computed(() => ({ aspectRatio: String(props.ratio) }));
const ratioLabel = computed(() => (Math.abs(props.ratio - 16 / 9) < 0.01 ? '16:9' : Math.abs(props.ratio - 4 / 5) < 0.01 ? '4:5' : ''));
</script>

<template>
    <div>
        <label v-if="!card" class="mb-1 block text-sm font-medium text-slate-600">
            {{ label }}
            <span v-if="ratioLabel" class="ml-1 text-xs text-slate-400">(อัตราส่วน {{ ratioLabel }})</span>
        </label>

        <!-- Cropping mode -->
        <div v-if="rawImage" class="space-y-2">
            <div class="overflow-hidden rounded-lg border bg-gray-900">
                <Cropper
                    ref="cropperRef"
                    :src="rawImage"
                    :stencil-props="{ aspectRatio: ratio }"
                    class="max-h-[360px]"
                />
            </div>
            <div class="flex gap-2">
                <button type="button" class="rounded-lg bg-pjs-blue px-4 py-2 text-sm text-white" @click="confirmCrop">
                    ครอบตัด &amp; ใช้รูปนี้
                </button>
                <button type="button" class="rounded-lg border px-4 py-2 text-sm text-slate-600" @click="rawImage = null">
                    ยกเลิก
                </button>
            </div>
        </div>

        <!-- Preview / picker (default) -->
        <div v-else-if="!card">
            <div class="relative overflow-hidden rounded-lg border bg-slate-50" :style="boxStyle">
                <img v-if="preview" :src="preview" class="h-full w-full object-cover" />
                <div v-else class="flex h-full items-center justify-center text-sm text-slate-400">ยังไม่มีรูป</div>
            </div>
            <div class="mt-2 flex gap-2">
                <button type="button" class="rounded-lg border px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50" @click="inputRef.click()">
                    เลือกรูป
                </button>
                <button v-if="preview" type="button" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-500 hover:bg-red-50" @click="clearImage">
                    ลบรูป
                </button>
                <input ref="inputRef" type="file" accept="image/*" class="hidden" @change="onSelect" />
            </div>
            <p v-if="hint" class="mt-1 text-xs text-slate-400">{{ hint }}</p>
        </div>

        <!-- Card style (เหมือนการ์ดโปรไฟล์) -->
        <div v-else>
            <div class="group relative overflow-hidden rounded-2xl border border-slate-100 shadow-sm" :style="boxStyle">
                <img v-if="preview" :src="preview" class="absolute inset-0 h-full w-full object-cover" />
                <div v-else class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-gradient-to-br from-pjs-blue to-pjs-blue-light">
                    <i class="bi bi-image text-5xl text-white/85"></i>
                    <span class="text-sm font-medium text-white/85">ยังไม่มีรูป</span>
                </div>

                <span class="absolute left-2.5 top-2.5 rounded-full bg-black/35 px-2.5 py-0.5 text-[11px] font-medium text-white backdrop-blur">{{ label }}</span>

                <div class="absolute inset-x-0 bottom-0 flex items-center gap-2 bg-gradient-to-t from-black/70 via-black/25 to-transparent p-3 pt-10">
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-white/90 px-3 py-1.5 text-sm font-medium text-slate-700 backdrop-blur transition hover:bg-white" @click="inputRef.click()">
                        <i class="bi bi-upload"></i> {{ preview ? 'เปลี่ยนรูป' : 'เลือกรูป' }}
                    </button>
                    <button v-if="preview" type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-red-500/90 px-3 py-1.5 text-sm text-white backdrop-blur transition hover:bg-red-600" @click="clearImage">
                        <i class="bi bi-trash"></i> ลบ
                    </button>
                    <span v-if="ratioLabel" class="ml-auto rounded-full bg-white/20 px-2 py-0.5 text-[10px] text-white backdrop-blur">{{ ratioLabel }}</span>
                </div>

                <input ref="inputRef" type="file" accept="image/*" class="hidden" @change="onSelect" />
            </div>
            <p v-if="hint" class="mt-2 text-xs text-slate-400">{{ hint }}</p>
        </div>
    </div>
</template>
