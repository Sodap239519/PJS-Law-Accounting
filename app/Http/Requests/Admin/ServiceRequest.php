<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:100'],
            'content' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],

            'cover' => ['nullable', 'image', 'max:5120'],
            'remove_cover' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return ['title' => 'ชื่อบริการ'];
    }
}
