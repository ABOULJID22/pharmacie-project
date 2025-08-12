<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\SiteSettingController;
/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
}); */
Route::get('/', [SiteSettingController::class, 'welcome']);

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');
/* Route::get('/admin', function () {
    return redirect()->route('filament.admin.pages.admin');
})->middleware(['auth', 'verified']); */
Route::post('/lang', function (Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['fr', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
});


// routes/web.php
Route::get('/api/faqs', [FaqController::class, 'getFaq'])->name('api.faqs');
//Route::get('/api/settinginfos', [SiteSettingController::class, 'getInfo']);
//Route::get('/', [SiteSettingController::class, 'showSettingsPage']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::get('/documents/{filename}', function ($filename) {
    $path = storage_path('app/private/documents/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    $mimeType = mime_content_type($path);
    return response()->file($path, ['Content-Type' => $mimeType]);
})->where('filename', '.*');



require __DIR__.'/auth.php';
