<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CaseStudyController extends Controller
{
    public function index(Request $request): View
    {
        $query = CaseStudy::published()
            ->with('category')
            ->orderBy('created_at', 'desc');

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)
                ->where('type', 'case_study')
                ->where('is_active', true)
                ->first();

            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $cases = $query->paginate(9);
        $categories = Category::where('type', 'case_study')
            ->where('is_active', true)
            ->get();

        return view('cases.index', compact('cases', 'categories'));
    }

    public function show(string $slug): View
    {
        $case = CaseStudy::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $case->increment('views');

        return view('cases.show', compact('case'));
    }
}
