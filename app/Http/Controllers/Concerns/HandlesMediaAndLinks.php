<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;

/**
 * ตัวช่วยจัดการรูป/ไฟล์ (spatie medialibrary) + ลิงก์แนบ (polymorphic)
 * ใช้ร่วมกันในทุก admin controller
 *
 * ข้อตกลง field ในฟอร์ม:
 *  - cover           : ไฟล์รูปปก (single)   / remove_cover=true เพื่อลบ
 *  - gallery[]       : ไฟล์รูปเพิ่ม (multi)
 *  - attachments[]   : ไฟล์แนบเพิ่ม (multi)
 *  - deleted_media[] : id ของ media ที่จะลบ
 *  - links[]         : [{label, url}]
 */
trait HandlesMediaAndLinks
{
    protected function syncCover(HasMedia $model, Request $request, string $collection = 'cover'): void
    {
        if ($request->boolean('remove_'.$collection)) {
            $model->clearMediaCollection($collection);
        }

        if ($request->hasFile($collection)) {
            $model->clearMediaCollection($collection);
            $model->addMediaFromRequest($collection)->toMediaCollection($collection);
        }
    }

    /**
     * ลบ media ตาม id ที่ผู้ใช้เลือกลบ (ทำครั้งเดียวต่อ request)
     */
    protected function deleteRemovedMedia(HasMedia $model, Request $request): void
    {
        $ids = array_filter((array) $request->input('deleted_media', []));

        if ($ids) {
            $model->media()->whereIn('id', $ids)->get()->each->delete();
        }
    }

    /**
     * เพิ่มไฟล์ใหม่หลายไฟล์เข้า collection
     */
    protected function addFiles(HasMedia $model, Request $request, string $field, string $collection): void
    {
        if ($request->hasFile($field)) {
            foreach ($request->file($field) as $file) {
                $model->addMedia($file)->toMediaCollection($collection);
            }
        }
    }

    /**
     * แทนที่ลิงก์แนบทั้งหมดด้วยชุดใหม่จากฟอร์ม
     */
    protected function syncLinks($model, Request $request): void
    {
        $model->links()->delete();

        foreach ((array) $request->input('links', []) as $i => $link) {
            if (! empty($link['url'])) {
                $model->links()->create([
                    'label' => $link['label'] ?? null,
                    'url' => $link['url'],
                    'sort_order' => $i,
                ]);
            }
        }
    }

    /**
     * แปลง media + links ของโมเดลเป็น payload ส่งให้ Inertia (หน้า edit)
     */
    protected function mediaPayload(HasMedia $model, bool $withLinks = true): array
    {
        $mapMedia = fn ($m) => [
            'id' => $m->id,
            'url' => $m->getUrl(),
            'name' => $m->file_name,
            'size' => $m->human_readable_size,
        ];

        $cover = $model->getFirstMedia('cover');

        $data = [
            'cover' => $cover ? $mapMedia($cover) : null,
            'gallery' => $model->getMedia('gallery')->map($mapMedia)->values(),
            'attachments' => $model->getMedia('attachments')->map($mapMedia)->values(),
        ];

        if ($withLinks && method_exists($model, 'links')) {
            $data['links'] = $model->links->map(fn ($l) => [
                'label' => $l->label,
                'url' => $l->url,
            ])->values();
        }

        return $data;
    }
}
