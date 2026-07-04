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

    // Phase 1 — โมดูลเนื้อหาหลัก
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class)->except(['show']);

    // TODO (Phase 1+): announcements, case-studies, services
    // TODO (Phase 2+): banners, about, team-members, documents, contact-channels, settings
    // TODO (Phase 3+): contacts, users
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
