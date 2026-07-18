<?php

use Illuminate\Support\Facades\Route;
use Modules\CRM\App\Http\Controllers\CRMController;
use Modules\CRM\App\Http\Controllers\JobsPostingController;
use Modules\CRM\App\Http\Controllers\FavouritesController;
use Modules\CRM\App\Http\Controllers\CustomersController;
use Modules\CRM\App\Http\Controllers\AgentController;
use Modules\CRM\App\Http\Controllers\ContactUsController;

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
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth', 'staff', 'check.route.permission']],
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


            // Favourites Routes
            Route::prefix('favourites')->group(function () {
                Route::get('/index', [FavouritesController::class, 'index'])->name('crm-favourites.index');
                Route::get('/export-report', [FavouritesController::class, 'exportReport'])->name('crm-favourites.export-report');
                Route::get('/live-search', [FavouritesController::class, 'liveSearch'])->name('crm-favourites.live-search');
                Route::get('/show/{sessionId}', [FavouritesController::class, 'show'])->name('crm-favourites.show');
                Route::post('/assign-agent/{sessionId}', [FavouritesController::class, 'assignAgent'])->name('crm-favourites.assign-agent');
                Route::post('/unassign-agent/{sessionId}', [FavouritesController::class, 'unassignAgent'])->name('crm-favourites.unassign-agent');
                Route::post('/update-user-info/{sessionId}', [FavouritesController::class, 'updateUserInfo'])->name('crm-favourites.update-user-info');
                Route::post('/delete-item/{id}', [FavouritesController::class, 'deleteItem'])->name('crm-favourites.delete-item');
                Route::post('/send-email/{sessionId}', [FavouritesController::class, 'sendEmail'])->name('crm-favourites.send-email');
                Route::post('/send-notification/{sessionId}', [FavouritesController::class, 'sendNotification'])->name('crm-favourites.send-notification');
                Route::post('/comment/{sessionId}', [FavouritesController::class, 'storeComment'])->name('crm-favourites.store-comment');
                Route::post('/comment-delete/{id}', [FavouritesController::class, 'deleteComment'])->name('crm-favourites.delete-comment');
            });

            // Customers Routes
            Route::prefix('customers')->group(function () {
                Route::get('/index', [CustomersController::class, 'index'])->name('crm-customers.index');
                Route::get('/export-report', [CustomersController::class, 'exportReport'])->name('crm-customers.export-report');
                Route::get('/live-search', [CustomersController::class, 'liveSearch'])->name('crm-customers.live-search');
                Route::get('/show/{id}', [CustomersController::class, 'show'])->name('crm-customers.show');
                Route::post('/assign-agent/{id}', [CustomersController::class, 'assignAgent'])->name('crm-customers.assign-agent');
                Route::post('/unassign-agent/{id}', [CustomersController::class, 'unassignAgent'])->name('crm-customers.unassign-agent');
                Route::post('/send-email/{id}', [CustomersController::class, 'sendEmail'])->name('crm-customers.send-email');
                Route::post('/comment/{id}', [CustomersController::class, 'storeComment'])->name('crm-customers.store-comment');
                Route::post('/comment-delete/{id}', [CustomersController::class, 'deleteComment'])->name('crm-customers.delete-comment');
            });

            // Contact Us Routes
            Route::prefix('contact-us')->group(function () {
                Route::get('/index', [ContactUsController::class, 'index'])->name('crm-contact-us.index');
                Route::get('/show/{id}', [ContactUsController::class, 'show'])->name('crm-contact-us.show');
                Route::post('/assign-agent/{id}', [ContactUsController::class, 'assignAgent'])->name('crm-contact-us.assign-agent');
                Route::post('/unassign-agent/{id}', [ContactUsController::class, 'unassignAgent'])->name('crm-contact-us.unassign-agent');
                Route::post('/update-status/{id}', [ContactUsController::class, 'updateStatus'])->name('crm-contact-us.update-status');
                Route::post('/update-notes/{id}', [ContactUsController::class, 'updateNotes'])->name('crm-contact-us.update-notes');
                Route::post('/add-comment/{id}', [ContactUsController::class, 'addComment'])->name('crm-contact-us.add-comment');
                Route::post('/delete-comment/{id}', [ContactUsController::class, 'deleteComment'])->name('crm-contact-us.delete-comment');
                Route::post('/send-reply/{id}', [ContactUsController::class, 'sendReply'])->name('crm-contact-us.send-reply');
                Route::post('/delete/{id}', [ContactUsController::class, 'destroy'])->name('crm-contact-us.delete');
            });

            // Agents Routes
            Route::prefix('agents')->group(function () {
                Route::get('/index', [AgentController::class, 'index'])->name('crm-agents.index');
                Route::get('/create', [AgentController::class, 'create'])->name('crm-agents.create');
                Route::post('/store', [AgentController::class, 'store'])->name('crm-agents.store');
                Route::get('/show/{id}', [AgentController::class, 'show'])->name('crm-agents.show');
                Route::get('/edit/{id}', [AgentController::class, 'edit'])->name('crm-agents.edit');
                Route::post('/update/{id}', [AgentController::class, 'update'])->name('crm-agents.update');
                Route::post('/delete/{id}', [AgentController::class, 'destroy'])->name('crm-agents.delete');
                Route::get('/trashed', [AgentController::class, 'trashed'])->name('crm-agents.trashed');
                Route::post('/restore/{id}', [AgentController::class, 'restore'])->name('crm-agents.restore');
            });

        });
    }
);

