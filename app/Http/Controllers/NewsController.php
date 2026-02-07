<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::published()
            ->with('category')
            ->orderBy('published_at', 'desc');

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)
                ->where('type', 'news')
                ->where('is_active', true)
                ->first();

            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $news = $query->paginate(12);
        $categories = Category::where('type', 'news')
            ->where('is_active', true)
            ->get();

        return view('news.index', compact('news', 'categories'));
    }

    public function show(string $slug): View
    {
        $news = News::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $news->increment('views');

        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->limit(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }
}
