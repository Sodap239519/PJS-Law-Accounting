<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $latestNews = \App\Models\News::published()
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $banners = \App\Models\Banner::where('is_active', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get();

        // เนื้อหา "เกี่ยวกับเรา" (ดึง section จากหน้าเกี่ยวกับเรา — โชว์ 2 อันแรกบนหน้าแรก)
        $about = \App\Models\AboutPage::singleton();

        // ลำดับ/การแสดงผล section หน้าแรก
        $homeLayout = \App\Support\HomeLayout::map();

        return view('home', compact('latestNews', 'banners', 'about', 'homeLayout'));
    }

    public function aboutLegal(): View
    {
        return view('home.about-legal');
    }

    public function aboutAccounting(): View
    {
        return view('home.about-accounting');
    }

    public function vision(): View
    {
        return view('vision');
    }
}
