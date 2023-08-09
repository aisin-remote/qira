<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('project')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('project');
        Route::get('/tambah', [ProjectController::class, 'tambah'])->name('project.tambah');
        Route::post('/tambah', [ProjectController::class, 'store'])->name('project.store');
        Route::get('/{id}/detail', [ProjectController::class, 'detail'])->where('id', '[0-9]+')->name('project.detail');
        Route::post('/{projectid}/updateStatus', [ProjectController::class, 'updateStatus'])->name('project.updateStatus');
        Route::post('/{projectid}/uploadDocument', [ProjectController::class, 'uploadDocument'])->name('project.uploadDocument');

    });
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/{id}', [CheckController::class, 'index'])->where('id', '[0-9]+')->name('product.check');
        Route::get('/{id}/tambah', [CheckController::class, 'tambah'])->where('id', '[0-9]+')->name('product.check.tambah');
        Route::post('/{id}/tambah', [CheckController::class, 'store'])->where('id', '[0-9]+')->name('product.check.store');

    });

});

require __DIR__.'/auth.php';
