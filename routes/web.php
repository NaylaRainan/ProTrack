<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\DepartmentController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SpkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect('/login');

});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| Home Redirect
|--------------------------------------------------------------------------
*/

Route::get(
    '/home',
    [HomeController::class, 'index']
)->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:admin'
])->group(function () {

    Route::get(
        '/admin',
        [DashboardController::class, 'index']
    );

    /*
    |-----------------------------------
    | Import XML
    |-----------------------------------
    */

    Route::get(
        '/import-xml',
        [ImportController::class, 'index']
    );

    Route::post(
        '/import-xml',
        [ImportController::class, 'import']
    );

    /*
    |-----------------------------------
    | SPK
    |-----------------------------------
    */

    Route::get(
        '/spk',
        [SpkController::class, 'index']
    );

    Route::get(
        '/spk/create',
        [SpkController::class, 'create']
    );

    Route::post(
        '/spk/store',
        [SpkController::class, 'store']
    );

    Route::get(
        '/spk/{id}/edit',
        [SpkController::class, 'edit']
    );

    Route::post(
        '/spk/{id}/update',
        [SpkController::class, 'update']
    );

    Route::post(
        '/spk-detail/{id}/delete',
        [SpkController::class, 'deleteDetail']
    )->name('spk.detail.delete');

    Route::get(
        '/spk/export',
        [SpkController::class, 'export']
    )->name('spk.export');

});

/*
|--------------------------------------------------------------------------
| SEMUA USER LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/spk/{id}',
        [SpkController::class, 'show']
    );

    Route::post(
        '/spk/{id}/update-status',
        [SpkController::class, 'updateStatus']
    );

});

/*
|--------------------------------------------------------------------------
| DEVELOP
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:develop'
])->group(function () {

    Route::get(
        '/develop',
        function () {

            return app(
                DepartmentController::class
            )->index(1, request());

        }
    );

});

/*
|--------------------------------------------------------------------------
| OFFSET
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:offset'
])->group(function () {

    Route::get(
        '/offset',
        function () {

            return app(
                DepartmentController::class
            )->index(2, request());

        }
    );

});

/*
|--------------------------------------------------------------------------
| PLOTTER
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:plotter'
])->group(function () {

    Route::get(
        '/plotter',
        function () {

            return app(
                DepartmentController::class
            )->index(3, request());

        }
    );

});

/*
|--------------------------------------------------------------------------
| UV
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:uv'
])->group(function () {

    Route::get(
        '/uv',
        function () {

            return app(
                DepartmentController::class
            )->index(4, request());

        }
    );

});

/*
|--------------------------------------------------------------------------
| FINISHING
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:finishing'
])->group(function () {

    Route::get(
        '/finishing',
        function () {

            return app(
                DepartmentController::class
            )->index(5, request());

        }
    );

});

Route::get(
    '/department/spk/{id}',
    [DepartmentController::class, 'show']
)->middleware('auth');

