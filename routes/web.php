<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerProblemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PicaController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    // Dahsboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/filter', [DashboardController::class, 'index'])->name('dashboard.filter');

    // Product
    Route::get('/product-check', function () {
        return view('prod.productCheck');
    })->name('product.check');
    Route::get('/product-report', [ProductController::class, 'index'])->name('product.report');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.updateData');
    Route::get('products/delete/{product}', [ProductController::class, 'delete'])->name('products.delete');
    Route::resource('products', ProductController::class);

    // Project
    Route::get('/project-check', function () {
        return view('proj.projectCheck');
    })->name('project.check');
    Route::get('/project-report', [ProjectController::class, 'index'])->name('project.report');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.updateData');
    Route::get('projects/deleteItemDetail', [ProjectController::class, 'deleteItemDetail'])->name('projects.deleteItemDetail');
    Route::get('projects/deleteItem', [ProjectController::class, 'deleteItem'])->name('projects.deleteItem');
    Route::resource('projects', ProjectController::class);

    // Problem
    Route::get('/problem-form', [CustomerProblemController::class, 'index'])->name('problem.form');
    Route::post('/customer-problems', [CustomerProblemController::class, 'store'])->name('customer-problems.store');
    Route::get('/customer-problems/{customerProblem}', [CustomerProblemController::class, 'show'])->name('customer-problems.show');
    Route::get('/customer-problems/{id}/edit', [CustomerProblemController::class, 'edit'])->name('customer-problems.edit');
    Route::put('/customer-problems/{id}', [CustomerProblemController::class, 'update'])->name('customer-problems.update');
    Route::get('costumer-problems/delete/{id}', [CustomerProblemController::class, 'delete'])->name('customer-problems.delete');

    // PICA
    Route::get('/pica-form', [PicaController::class, 'index'])->name('pica.form');
    Route::get('/pica/{id}/edit', [PicaController::class, 'edit'])->name('pica.editData');
    Route::put('/pica/{id}', [PicaController::class, 'update'])->name('pica.updateData');
    Route::get('/pica/delete/{id}', [PicaController::class, 'delete'])->name('pica.delete');
    Route::resource('pica', PicaController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
