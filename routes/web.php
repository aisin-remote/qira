<?php

use Illuminate\Support\Facades\Route;
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

    Route::get('/product-check', function () {
        return view('prod.productCheck');
    })->name('product.check');

    Route::get('/project-check', function () {
        return view('proj.projectCheck');
    })->name('project.check');

    Route::get('/project-report', [ProjectController::class, 'index'])->name('project.report');

    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.updateData');

    Route::get('projects/deleteItemDetail', [ProjectController::class, 'deleteItemDetail'])->name('projects.deleteItemDetail');
    Route::get('projects/deleteItem', [ProjectController::class, 'deleteItem'])->name('projects.deleteItem');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified']);

    Route::resource('projects', ProjectController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
