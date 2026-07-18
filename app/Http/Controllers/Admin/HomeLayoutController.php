<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\HomeLayout;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeLayoutController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/HomeLayout/Edit', [
            'sections' => HomeLayout::items(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sections' => ['required', 'array'],
            'sections.*.key' => ['required', 'string'],
            'sections.*.visible' => ['boolean'],
        ]);

        HomeLayout::save($data['sections']);

        return back()->with('success', 'บันทึกการจัดการหน้าแรกเรียบร้อยแล้ว');
    }
}
