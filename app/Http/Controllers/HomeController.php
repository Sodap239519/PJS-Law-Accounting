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
            
        return view('home', compact('latestNews'));
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
