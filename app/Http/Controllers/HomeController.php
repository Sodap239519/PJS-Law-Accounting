<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index');
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
        $visionText = 'ความเชี่ยวชาญเหนือระดับ เปลี่ยนเรื่องกฎหมายให้เป็นเรื่องง่าย เพื่อทุกความสำเร็จของคุณและธุรกิจ';
        
        return view('home.vision', compact('visionText'));
    }
}
