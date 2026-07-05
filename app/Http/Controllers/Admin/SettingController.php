<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Settings/Edit', [
            'settings' => [
                'site_name' => Setting::get('site_name', 'PJS Law and Accounting'),
                'tagline' => Setting::get('tagline', ''),
                'logo' => Setting::get('logo'),
                'favicon' => Setting::get('favicon'),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:1024'],
            'remove_logo' => ['boolean'],
            'remove_favicon' => ['boolean'],
        ]);

        Setting::set('site_name', $request->input('site_name'), 'site');
        Setting::set('tagline', $request->input('tagline'), 'site');

        foreach (['logo', 'favicon'] as $field) {
            if ($request->boolean('remove_'.$field)) {
                $this->deleteFile(Setting::get($field));
                Setting::set($field, null, 'site');
            }

            if ($request->hasFile($field)) {
                $this->deleteFile(Setting::get($field));
                $path = $request->file($field)->store('settings', 'public');
                Setting::set($field, Storage::disk('public')->url($path), 'site');
            }
        }

        return back()->with('success', 'บันทึกการตั้งค่าเรียบร้อยแล้ว');
    }

    private function deleteFile(?string $url): void
    {
        if (! $url) {
            return;
        }

        $path = ltrim(str_replace('/storage/', '', (string) parse_url($url, PHP_URL_PATH)), '/');

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
