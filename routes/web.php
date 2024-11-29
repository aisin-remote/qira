<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerProblemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PicaController;

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
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/filter', [DashboardController::class, 'index'])->name('dashboard.filter');

    // Quality Body Dashboard
    Route::get('/dashboard/quality-body', [DashboardController::class, 'qualityBodyDashboard'])->name('dashboard.quality_body');

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
        Route::get('projects/deleteItemDetail/{id}', [ProjectController::class, 'deleteItemDetail'])->name('projects.deleteItemDetail');
        Route::get('projects/deleteItem/{id}', [ProjectController::class, 'deleteItem'])->name('projects.deleteItem');
        Route::resource('projects', ProjectController::class);
        Route::get('/project-check-body', function () {
            return view('proj.projectCheckBody');
        })->name('project.check.body');
        Route::post('/projects/check-body', [ProjectController::class, 'storeBody'])->name('projects.body.store');
        Route::get('/project-report-body', [ProjectController::class, 'project'])->name('project.body.report');
        Route::get('/projects/body/{project}/edit', [ProjectController::class, 'editBody'])->name('projects.body.edit');
        Route::put('/projects/body/{project}', [ProjectController::class, 'updateBody'])->name('projects.updateDataBody');
        Route::get('projects/deleteItemDetailBody/{id}', [ProjectController::class, 'deleteItemDetailBody'])->name('projects.deleteItemDetailBody');
        Route::get('projects/deleteItemBody/{id}', [ProjectController::class, 'deleteItemBody'])->name('projects.deleteItemBody');
        Route::resource('projects/body', ProjectController::class);
    });

    // Problem
    Route::get('/problem-form', [CustomerProblemController::class, 'index'])->name('problem.form');
    Route::post('/customer-problems', [CustomerProblemController::class, 'store'])->name('customer-problems.store');
    Route::get('/customer-problems/{customerProblem}', [CustomerProblemController::class, 'show'])->name('customer-problems.show');
    Route::get('/customer-problems/{id}/edit', [CustomerProblemController::class, 'edit'])->name('customer-problems.edit');
    Route::put('/customer-problems/{id}', [CustomerProblemController::class, 'update'])->name('customer-problems.update');
    Route::get('costumer-problems/delete/{id}', [CustomerProblemController::class, 'delete'])->name('customer-problems.delete');
    Route::get('/problem-form-body', [CustomerProblemController::class, 'body'])->name('problemBody.form');
    Route::post('/customer-problems-body', [CustomerProblemController::class, 'storeBody'])->name('customer-problems-body.store');
    Route::get('/customer-problems-body/{customerProblemBody}', [CustomerProblemController::class, 'showBody'])->name('customer-problems-body.show');
    Route::get('/customer-problems-body/{id}/editBody', [CustomerProblemController::class, 'editBody'])->name('customer-problems-body.edit');
    Route::put('/customer-problems-body/{id}', [CustomerProblemController::class, 'updateBody'])->name('customer-problems-body.update');
    Route::get('customer-problems-body/delete/{id}', [CustomerProblemController::class, 'deleteBody'])->name('customer-problems-body.delete');

    // PICA
    Route::get('/pica', [PicaController::class, 'showPica'])->name('pica.show');
    Route::get('/customer', [PicaController::class, 'customer'])->name('pica.customer');
    Route::post('/store/customer', [PicaController::class, 'storeCustomer'])->name('pica.customer.store');
    Route::get('/pica/customer/{id}/edit', [PicaController::class, 'editCustomer'])->name('pica.customer.edit');
    Route::put('/pica/customer/{id}', [PicaController::class, 'updateCustomer'])->name('pica.customer.update');
    Route::delete('/customer/{id}', [PicaController::class, 'deleteCustomer'])->name('customer.delete');
    Route::get('/pica/internal', [PicaController::class, 'internal'])->name('pica.internal');
    Route::post('/store/internal', [PicaController::class, 'storeInternal'])->name('pica.internal.store');
    Route::get('/pica/internal/{id}/edit', [PicaController::class, 'editInternal'])->name('pica.internal.edit');
    Route::put('/pica/internal/{id}', [PicaController::class, 'updateInternal'])->name('pica.internal.update');
    Route::delete('/internal/{id}', [PicaController::class, 'deleteInternal'])->name('internal.delete');
    Route::get('/pica/form', [PicaController::class, 'index'])->name('pica.form');
    Route::post('/pica/store', [PicaController::class, 'store'])->name('pica.store');
    Route::get('/download/report/{id}', [PicaController::class, 'downloadExcel'])->name('download.report');
    Route::get('/pica/{id}/edit', [PicaController::class, 'edit'])->name('pica.editData');
    Route::put('/pica/{id}', [PicaController::class, 'update'])->name('pica.updateData');
    Route::delete('/pica/delete/{id}', [PicaController::class, 'delete'])->name('pica.delete');
    Route::get('/download-excel/{documentId}', [PicaController::class, 'downloadExcel'])->name('download.excel');
    Route::get('/download-excel-internal/{documentId}', [PicaController::class, 'downloadExcelInternal'])->name('download.excel.internal');



// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
