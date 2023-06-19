<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/project', [ProjectController::class, 'index'])->name('project');
    Route::get('/project/tambah', [ProjectController::class, 'tambah'])->name('project.tambah');
    Route::post('/project/tambah', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{id}/detail', [ProjectController::class, 'detail'])->where('id', '[0-9]+')->name('project.detail');

});

require __DIR__.'/auth.php';
