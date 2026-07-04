<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Language Switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'th'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'th'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about.index');
Route::get('/about/legal', [HomeController::class, 'aboutLegal'])->name('about.legal');
Route::get('/about/accounting', [HomeController::class, 'aboutAccounting'])->name('about.accounting');
Route::get('/vision', [HomeController::class, 'vision'])->name('vision');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

Route::get('/team', [TeamController::class, 'index'])->name('team.index');

// ===== News (static pages — served live) =====
Route::view('/news', 'news.index-news')->name('news.index');
Route::view('/news/news-show-1', 'news.news-show-1')->name('news.show1');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// ===== Case Studies (static pages — served live) =====
Route::view('/case-index', 'cases.case-index')->name('cases.index');
Route::view('/case', 'cases.case-index')->name('case.index'); // alias used by "back" links on show pages
Route::view('/case/case-studies-show-1', 'cases.case-studies-show-1')->name('cases.show.case1');
Route::view('/case/case-studies-show-2', 'cases.case-studies-show-2')->name('cases.show.case2');
Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show'])->name('cases.show');


Route::get('/downloads', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/downloads/{id}/download', [DocumentController::class, 'download'])->name('documents.download');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Dashboard redirect (for Breeze compatibility)
Route::middleware(['auth'])->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin CRUD routes
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
    Route::resource('case-studies', \App\Http\Controllers\Admin\CaseStudyController::class);
    Route::resource('team-members', \App\Http\Controllers\Admin\TeamMemberController::class);
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{id}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
});

require __DIR__.'/auth.php';