<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    /**
     * รับรูปที่อัปโหลดจากตัวแก้ไขข้อความ (TinyMCE) แล้วคืน URL
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:5120'],
        ]);

        $path = $request->file('file')->store('editor', 'public');

        // URL แบบ relative (ทำงานทุกพอร์ต/โดเมน) — ตรงกับ TinyMCE ที่ต้องการ { location }
        return response()->json([
            'location' => Storage::disk('public')->url($path),
        ]);
    }
}
