<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('../auth/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [FileController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::patch('/dashboard/files/{file}/rename', [FileController::class, 'rename'])->name('files.rename');
    Route::delete('/dashboard/files/{file}', [FileController::class, 'delete'])->name('files.delete');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::group(['prefix' => '{session_id}', 'middleware' => 'check.session'], function () {
//     Route::get('/dashboard', [FileController::class, 'index'])->name('dashboard');
//     Route::post('/dashboard/upload', [FileController::class, 'upload'])->name('files.upload');
//     Route::patch('/dashboard/files/{file}/rename', [FileController::class, 'rename'])->name('files.rename');
//     Route::delete('/dashboard/files/{file}', [FileController::class, 'delete'])->name('files.delete');
//     Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
// });

require __DIR__.'/auth.php';