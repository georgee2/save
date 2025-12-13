<?php

use Illuminate\Support\Facades\Route;
use Modules\CRM\App\Http\Controllers\CRMController;
use Modules\CRM\App\Http\Controllers\JobsPostingController;

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

Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' , 'middleware' => 'auth']],
    function () {

        Route::prefix('crm')->group(function () {

            // CRM Dashboard Route
            Route::get('/', [CRMController::class, 'index'])->name('CRM');

            // Jobs Postings Routes
            Route::prefix('jobs-posting')->group(function () {
                Route::get('/index', [JobsPostingController::class, 'index'])->name('jobs-posting.index');
                Route::get('/create', [JobsPostingController::class, 'create'])->name('jobs-posting.create');
                Route::post('/store', [JobsPostingController::class, 'store'])->name('jobs-posting.store');
                Route::get('/show/{id}', [JobsPostingController::class, 'show'])->name('jobs-posting.show');
                Route::get('/edit/{id}', [JobsPostingController::class, 'edit'])->name('jobs-posting.edit');
                Route::post('/update/{id}', [JobsPostingController::class, 'update'])->name('jobs-posting.update');
                Route::post('/delete/{id}', [JobsPostingController::class, 'destroy'])->name('jobs-posting.delete');
                Route::get('/trashed', [JobsPostingController::class, 'trashed'])->name('jobs-posting.trashed');
                Route::post('/restore/{id}', [JobsPostingController::class, 'restore'])->name('jobs-posting.restore');
            });


        });
    }
);

