<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
 * โมเดลเหล่านี้ผูก route หน้าเว็บสาธารณะด้วย slug (getRouteKeyName='slug')
 * แต่หลังบ้าน (/admin) ใช้ id — bind พารามิเตอร์ของ resource admin ให้หาโดย id
 * (หน้าเว็บสาธารณะใช้ param ชื่อ {slug} + ค้นเองในคอนโทรลเลอร์ จึงไม่กระทบ)
 */
Route::bind('news', fn ($value) => \App\Models\News::findOrFail($value));
Route::bind('announcement', fn ($value) => \App\Models\Announcement::findOrFail($value));
Route::bind('case_study', fn ($value) => \App\Models\CaseStudy::findOrFail($value));

/*
|--------------------------------------------------------------------------
| Language switcher
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'th'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Public site (Blade + Boomerang template)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/vision', [HomeController::class, 'vision'])->name('vision');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/team', [TeamController::class, 'index'])->name('team.index');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('cases.index');
Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show'])->name('cases.show');

Route::get('/downloads', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/downloads/{id}/download', [DocumentController::class, 'download'])->name('documents.download');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Admin (Inertia + Vue) — /admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // อัปโหลดรูปจากตัวแก้ไขข้อความ (TinyMCE)
    Route::post('editor/image', [\App\Http\Controllers\Admin\EditorController::class, 'uploadImage'])->name('editor.image');

    // Phase 1 — โมดูลเนื้อหาหลัก
    Route::patch('news/{news}/toggle', [\App\Http\Controllers\Admin\NewsController::class, 'togglePublish'])->name('news.toggle');
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->except(['show']);
    Route::get('announcements/calendar', [\App\Http\Controllers\Admin\AnnouncementController::class, 'calendar'])->name('announcements.calendar');
    Route::patch('announcements/{announcement}/toggle', [\App\Http\Controllers\Admin\AnnouncementController::class, 'togglePublish'])->name('announcements.toggle');
    Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class)->except(['show']);
    Route::patch('case-studies/{case_study}/toggle', [\App\Http\Controllers\Admin\CaseStudyController::class, 'togglePublish'])->name('case-studies.toggle');
    Route::resource('case-studies', \App\Http\Controllers\Admin\CaseStudyController::class)->except(['show']);
    Route::post('services/reorder', [\App\Http\Controllers\Admin\ServiceController::class, 'reorder'])->name('services.reorder');
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class)->except(['show']);

    // กล่องข้อความ (inbox ในระบบ)
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    // Phase 2 — โมดูลย่อย
    Route::post('banners/reorder', [\App\Http\Controllers\Admin\BannerController::class, 'reorder'])->name('banners.reorder');
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class)->except(['show']);

    Route::post('team-members/reorder', [\App\Http\Controllers\Admin\TeamMemberController::class, 'reorder'])->name('team-members.reorder');
    Route::resource('team-members', \App\Http\Controllers\Admin\TeamMemberController::class)->except(['show']);

    Route::post('contact-channels/reorder', [\App\Http\Controllers\Admin\ContactChannelController::class, 'reorder'])->name('contact-channels.reorder');
    Route::resource('contact-channels', \App\Http\Controllers\Admin\ContactChannelController::class)->except(['show']);

    Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class)->except(['show']);

    Route::get('about', [\App\Http\Controllers\Admin\AboutPageController::class, 'edit'])->name('about.edit');
    Route::put('about', [\App\Http\Controllers\Admin\AboutPageController::class, 'update'])->name('about.update');

    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    Route::get('home-layout', [\App\Http\Controllers\Admin\HomeLayoutController::class, 'edit'])->name('home-layout.edit');
    Route::put('home-layout', [\App\Http\Controllers\Admin\HomeLayoutController::class, 'update'])->name('home-layout.update');

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->only(['index', 'store', 'update', 'destroy']);

    // Phase 3 — เฉพาะ super_admin
    Route::middleware('super_admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['show']);
        Route::get('menus', [\App\Http\Controllers\Admin\MenuController::class, 'edit'])->name('menus.index');
        Route::put('menus', [\App\Http\Controllers\Admin\MenuController::class, 'update'])->name('menus.update');
    });
});

// Profile (แก้โปรไฟล์ตัวเอง — ทุก admin) — คงชื่อ profile.* ให้หน้า Vue ของ Breeze ใช้ได้
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// เผื่อ redirect เก่าของ Breeze
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))
    ->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php';
