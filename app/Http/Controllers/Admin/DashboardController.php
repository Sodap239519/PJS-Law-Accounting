<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\CaseStudy;
use App\Models\Contact;
use App\Models\Document;
use App\Models\News;
use App\Models\Service;
use App\Models\TeamMember;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'news' => News::count(),
            'announcements' => Announcement::count(),
            'caseStudies' => CaseStudy::count(),
            'services' => Service::count(),
            'documents' => Document::count(),
            'team' => TeamMember::count(),
            'banners' => Banner::count(),
            'unreadContacts' => Contact::where('is_read', false)->count(),
        ];

        $totalViews = News::sum('views') + Announcement::sum('views') + CaseStudy::sum('views');
        $publishedNews = News::where('is_published', true)->count();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'meta' => [
                'totalViews' => (int) $totalViews,
                'publishedNews' => $publishedNews,
                'draftNews' => max(0, $stats['news'] - $publishedNews),
                'totalContent' => $stats['news'] + $stats['announcements'] + $stats['caseStudies'] + $stats['services'],
            ],
            'contentByType' => [
                ['label' => 'ข่าวสาร/กิจกรรม', 'value' => $stats['news'], 'route' => 'admin.news.index'],
                ['label' => 'ประชาสัมพันธ์', 'value' => $stats['announcements'], 'route' => 'admin.announcements.index'],
                ['label' => 'คดีตัวอย่าง', 'value' => $stats['caseStudies'], 'route' => 'admin.case-studies.index'],
                ['label' => 'บริการ', 'value' => $stats['services'], 'route' => 'admin.services.index'],
                ['label' => 'เอกสาร', 'value' => $stats['documents'], 'route' => 'admin.documents.index'],
            ],
            'recentNews' => News::latest()->take(5)->get()->map(fn (News $n) => [
                'id' => $n->id,
                'title' => $n->title,
                'is_published' => $n->is_published,
                'date' => optional($n->published_at ?? $n->created_at)->format('d/m/Y'),
                'views' => $n->views,
            ]),
        ]);
    }
}
