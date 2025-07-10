<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::Resource('/tasks', TaskController::class)->middleware('auth');
    Route::post('/tasks/share/{task}', [TaskController::class, 'share'])->name('tasks.share');
});

Route::get('/tasks/shared-view/{token}', [TaskController::class, 'sharedView'])->name('tasks.shared-view');

Auth::routes();
