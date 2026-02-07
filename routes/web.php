<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
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

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about/legal', [HomeController::class, 'aboutLegal'])->name('about.legal');
Route::get('/about/accounting', [HomeController::class, 'aboutAccounting'])->name('about.accounting');
Route::get('/vision', [HomeController::class, 'vision'])->name('vision');

Route::get('/team', [TeamController::class, 'index'])->name('team.index');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('cases.index');
Route::get('/case-studies/{slug}', [CaseStudyController::class, 'show'])->name('cases.show');

Route::get('/downloads', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/downloads/{id}/download', [DocumentController::class, 'download'])->name('documents.download');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

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
