<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CareerController;



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

Route::group(['prefix' => LaravelLocalization::setLocale() , 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']] , function(){


	Route::get('/login', [LoginController::class, 'login'])->name('login');
	Route::post('/checkuser', [LoginController::class, 'checkuser'])->name('checkuser');
	Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


	Route::get('/', [HomeController::class, 'index'])->name('index');

	// Services Routes Group
	Route::prefix('services')->name('services.')->group(function () {
		Route::get('/', [ServiceController::class, 'index'])->name('index');
		Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
            });

	// Projects Routes Group
	Route::prefix('projects')->name('projects.')->group(function () {
		Route::get('/', [ProjectsController::class, 'index'])->name('index');
		Route::get('/{slug}', [ProjectsController::class, 'show'])->name('show');
	});

	// Portfolio Routes Group
	Route::prefix('portfolios')->name('portfolios.')->group(function () {
		Route::get('/', [PortfolioController::class, 'index'])->name('index');
		Route::get('/{slug}', [PortfolioController::class, 'show'])->name('show');
	});

	// Showcase Routes Group
	Route::prefix('showcases')->name('showcases.')->group(function () {
		Route::get('/', [ShowcaseController::class, 'index'])->name('index');
		Route::get('/{id}', [ShowcaseController::class, 'show'])->name('show');
	});

	// Blog Routes Group
	Route::prefix('blogs')->name('blogs.')->group(function () {
		Route::get('/', [BlogController::class, 'index'])->name('index');
		Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
	});

	// About Route
	Route::get('/about', [AboutController::class, 'index'])->name('about');

	// Team Routes Group
	Route::prefix('team')->name('team.')->group(function () {
		Route::get('/', [TeamController::class, 'index'])->name('index');
		Route::get('/{id}', [TeamController::class, 'show'])->name('member');
	});

	// Contact Routes
	Route::get('/contact', [ContactController::class, 'index'])->name('contact');
	Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

	// Careers Routes Group
	Route::prefix('careers')->name('careers.')->group(function () {
		Route::get('/', [CareerController::class, 'index'])->name('index');
		Route::get('/{id}', [CareerController::class, 'show'])->name('show');
		Route::post('/{id}/apply', [CareerController::class, 'apply'])->name('apply');
	});

});
