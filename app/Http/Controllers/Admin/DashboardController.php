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
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'news' => News::count(),
                'announcements' => Announcement::count(),
                'caseStudies' => CaseStudy::count(),
                'services' => Service::count(),
                'documents' => Document::count(),
                'team' => TeamMember::count(),
                'banners' => Banner::count(),
                'unreadContacts' => Contact::where('is_read', false)->count(),
            ],
        ]);
    }
}
