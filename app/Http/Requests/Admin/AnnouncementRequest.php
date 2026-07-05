<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('announcement')?->id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('announcements', 'slug')->ignore($id)],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'translations' => ['nullable', 'array'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],

            'cover' => ['nullable', 'image', 'max:5120'],
            'remove_cover' => ['boolean'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:5120'],
            'gallery_order' => ['nullable', 'array'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240'],
            'deleted_media' => ['nullable', 'array'],

            'links' => ['nullable', 'array'],
            'links.*.label' => ['nullable', 'string', 'max:255'],
            'links.*.url' => ['nullable', 'url', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'หัวข้อ',
            'content' => 'เนื้อหา',
        ];
    }
}
