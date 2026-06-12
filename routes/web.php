<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Admin\SpkController;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin']);

Route::get('/develop', function () {
    return app(
        DepartmentController::class
    )->department(1);
})->middleware(['auth', 'role:develop']);

Route::get('/offset', function () {
    return app(
        DepartmentController::class
    )->department(2);
})->middleware(['auth', 'role:offset']);

Route::get('/plotter', function () {
    return app(
        DepartmentController::class
    )->department(3);
})->middleware(['auth', 'role:plotter']);

Route::get('/uv', function () {
    return app(
        DepartmentController::class
    )->department(4);
})->middleware(['auth', 'role:uv']);

Route::get('/finishing', function () {
    return app(
        DepartmentController::class
    )->department(5);
})->middleware(['auth', 'role:finishing']);

Route::get('/import-xml', [ImportController::class, 'index'])
    ->middleware(['auth', 'role:admin']);

Route::post('/import-xml', [ImportController::class, 'import'])
    ->middleware(['auth', 'role:admin']);

Route::get('/spk', [SpkController::class, 'index'])
    ->middleware(['auth', 'role:admin']);

Route::get(
    '/spk/export',
    [SpkController::class, 'export']
)->name('spk.export');

Route::get(
    '/spk/create',
    [SpkController::class, 'create']
)->middleware(['auth', 'role:admin']);

Route::post(
    '/spk/store',
    [SpkController::class, 'store']
)->middleware(['auth', 'role:admin']);

Route::post(
    '/spk-detail/{id}/delete',
    [SpkController::class, 'deleteDetail']
)->name('spk.detail.delete');

Route::get('/spk/{id}', [SpkController::class, 'show'])
    ->middleware('auth');

Route::get(
    '/spk/{id}/edit',
    [SpkController::class, 'edit']
)->middleware(['auth', 'role:admin']);

Route::post(
    '/spk/{id}/update',
    [SpkController::class, 'update']
)->middleware(['auth', 'role:admin']);

Route::post(
    '/spk/{id}/update-status',
    [SpkController::class, 'updateStatus']
)->middleware('auth');