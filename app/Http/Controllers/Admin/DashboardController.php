<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\CaseStudy;
use App\Models\Contact;
use App\Models\DailyStat;
use App\Models\Document;
use App\Models\News;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Support\Carbon;
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
            'chart' => $this->chartData(),
            'prCalendar' => $this->prCalendar(),
        ]);
    }

    private function chartData(): array
    {
        $from = today()->subDays(13);
        $byDate = DailyStat::whereBetween('date', [$from, today()])->get()
            ->keyBy(fn ($s) => $s->date->toDateString());

        $days = collect(range(13, 0))->map(fn ($i) => today()->subDays($i));

        return [
            'labels' => $days->map(fn (Carbon $d) => $d->format('j/n'))->values(),
            'views' => $days->map(fn (Carbon $d) => (int) optional($byDate->get($d->toDateString()))->views)->values(),
            'messages' => $days->map(fn (Carbon $d) => (int) optional($byDate->get($d->toDateString()))->messages)->values(),
        ];
    }

    private function prCalendar(): array
    {
        $month = today()->startOfMonth();

        $events = Announcement::whereNotNull('published_at')
            ->whereYear('published_at', $month->year)
            ->whereMonth('published_at', $month->month)
            ->get()
            ->groupBy(fn (Announcement $a) => $a->published_at->day)
            ->map->count();

        return [
            'monthLabel' => $month->locale('th')->translatedFormat('F Y'),
            'daysInMonth' => $month->daysInMonth,
            'startWeekday' => (int) $month->dayOfWeek, // 0 = อาทิตย์
            'today' => today()->month === $month->month ? today()->day : null,
            'events' => $events,
        ];
    }
}
