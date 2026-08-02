<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsHeartbeatController;
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
use App\Http\Controllers\EngineeringSubCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PartnerPageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\InteriorGalleryController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\CustomerPasswordController;
use App\Http\Controllers\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\Auth\StaffPasswordController;
use App\Http\Controllers\Account\DashboardController as AccountDashboardController;
use App\Http\Controllers\Account\ProfileController as AccountProfileController;
use App\Http\Controllers\Account\ProfileSettingsController as AccountSettingsController;
use App\Http\Controllers\Account\FavouritesController as AccountFavouritesController;



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

	// Global Search Routes
	Route::prefix('search')->name('search.')->group(function () {
		Route::get('/', [GlobalSearchController::class, 'search'])->name('index');
		Route::get('/live', [GlobalSearchController::class, 'liveSearch'])->name('live');
		Route::get('/emirates', [GlobalSearchController::class, 'getEmirates'])->name('emirates');
		Route::get('/categories', [GlobalSearchController::class, 'getCategories'])->name('categories');
		Route::get('/subcategories', [GlobalSearchController::class, 'getSubcategories'])->name('subcategories');
		Route::get('/types', [GlobalSearchController::class, 'getTypes'])->name('types');
		Route::get('/styles', [GlobalSearchController::class, 'getStyles'])->name('styles');
	});


	Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('cache.headers:no_store,no_cache,must_revalidate,max_age=0');
	Route::post('/checkuser', [LoginController::class, 'checkuser'])->name('checkuser')->middleware('throttle:30,1');
	Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

	// Customer registration + account activation (front-end portal)
	Route::get('/register', [CustomerRegisterController::class, 'showForm'])->name('account.register')->middleware('cache.headers:no_store,no_cache,must_revalidate,max_age=0');
	Route::post('/register', [CustomerRegisterController::class, 'register'])->name('account.register.submit')->middleware('throttle:5,1');
	Route::get('/set-password/{token}', [CustomerPasswordController::class, 'showForm'])->name('account.password.set')->middleware('cache.headers:no_store,no_cache,must_revalidate,max_age=0');
	Route::post('/set-password', [CustomerPasswordController::class, 'setPassword'])->name('account.password.update')->middleware('throttle:6,1');

	// Resend account-activation invite (uniform response, no user enumeration)
	Route::get('/resend-activation', [CustomerRegisterController::class, 'showResendForm'])->name('account.activation.resend.form')->middleware('cache.headers:no_store,no_cache,must_revalidate,max_age=0');
	Route::post('/resend-activation', [CustomerRegisterController::class, 'resendActivation'])->name('account.activation.resend')->middleware('throttle:5,1');

	// Forgot password (request a reset link; consumption reuses set-password above)
	Route::get('/forgot-password', [CustomerForgotPasswordController::class, 'showRequestForm'])->name('password.request')->middleware('cache.headers:no_store,no_cache,must_revalidate,max_age=0');
	Route::post('/forgot-password', [CustomerForgotPasswordController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:5,1');

	// Staff password reset (link target for the CMS self-service reset; staff accounts only)
	Route::get('/staff/reset-password/{token}', [StaffPasswordController::class, 'showForm'])->name('staff.password.reset')->middleware('cache.headers:no_store,no_cache,must_revalidate,max_age=0');
	Route::post('/staff/reset-password', [StaffPasswordController::class, 'reset'])->name('staff.password.update')->middleware('throttle:6,1');

	// Customer portal (customer accounts only)
	Route::middleware(['auth', 'customer', 'cache.headers:no_store,no_cache,must_revalidate,max_age=0'])->prefix('account')->group(function () {
		Route::get('/', [AccountDashboardController::class, 'index'])->name('account.dashboard');
		Route::get('/profile', [AccountProfileController::class, 'show'])->name('account.profile');
		Route::get('/favourites', [AccountFavouritesController::class, 'index'])->name('account.favourites');

		Route::get('/settings', [AccountSettingsController::class, 'edit'])->name('account.settings');
		Route::put('/settings/details', [AccountSettingsController::class, 'updateDetails'])->name('account.settings.details');
		Route::put('/settings/password', [AccountSettingsController::class, 'updatePassword'])->name('account.settings.password');
		Route::put('/settings/preferences', [AccountSettingsController::class, 'updatePreferences'])->name('account.settings.preferences');

		Route::get('/email/verify/{token}', [AccountSettingsController::class, 'verifyNewEmail'])
			->name('account.email.verify')
			->middleware('signed');
	});


	Route::get('/', [HomeController::class, 'index'])->name('index');
	
	// Private access route for data entry during under construction
	Route::get('/home', [HomeController::class, 'index'])->name('home.private');

	// Services Routes Group
	Route::prefix('services')->name('services.')->group(function () {
		Route::get('/', [ServiceController::class, 'index'])->name('index');
		Route::get('/{slug}', [ServiceController::class, 'show'])->name('show');
            });

	// Projects Routes Group
	Route::prefix('projects')->name('projects.')->group(function () {
		Route::get('/', [ProjectsController::class, 'index'])->name('index');
		Route::get('/featured', [ProjectsController::class, 'featured'])->name('featured');
		Route::get('/specification-values', [ProjectsController::class, 'getSpecificationValues'])->name('specification-values');
		Route::get('/{slug}', [ProjectsController::class, 'show'])->name('show');
	});

	// Engineering Sub Categories Routes Group (legacy route - redirects to new subcategory route)
	Route::prefix('engineering')->name('engineering.')->group(function () {
		Route::get('/{slug}', [EngineeringSubCategoryController::class, 'show'])->name('subcategory.show');
	});

	// Subcategory Routes Group (Projects by Subcategory)
	Route::prefix('subcategory')->name('subcategory.')->group(function () {
		Route::get('/{slug}', [EngineeringSubCategoryController::class, 'show'])->name('show');
	});

	// Category Routes Group (Projects by Category)
	Route::prefix('category')->name('category.')->group(function () {
		Route::get('/{slug}', [CategoryController::class, 'show'])->name('show');
	});

	// Offers Routes Group
	Route::prefix('offers')->name('offers.')->group(function () {
		Route::get('/', [OffersController::class, 'index'])->name('index');
		Route::get('/category/{slug}', [OffersController::class, 'category'])->name('category');
		Route::get('/subcategory/{slug}', [OffersController::class, 'subcategory'])->name('subcategory');
		Route::get('/{slug}', [OffersController::class, 'show'])->name('show');
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
		Route::get('/board-of-directors', [TeamController::class, 'board'])->name('board');
		Route::get('/{id}', [TeamController::class, 'show'])->name('member');
	});

	// Branches Routes
	Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
	Route::get('/branches/{id}', [BranchController::class, 'show'])->name('branches.show');

	// Partners Routes
	Route::get('/partners', [PartnerPageController::class, 'index'])->name('partners.index');
	Route::get('/partners/{id}', [PartnerPageController::class, 'show'])->name('partners.show');

	// Contact Routes
	Route::get('/contact', [ContactController::class, 'index'])->name('contact');
	Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:5,1');

	// Careers Routes Group
	Route::prefix('careers')->name('careers.')->group(function () {
		Route::get('/', [CareerController::class, 'index'])->name('index');
		Route::get('/{id}', [CareerController::class, 'show'])->name('show');
		Route::post('/{id}/apply', [CareerController::class, 'apply'])->name('apply')->middleware('throttle:5,1');
	});

	// Interior Design Gallery Routes
	Route::prefix('interior-design')->name('interior.')->group(function () {
		Route::get('/', [InteriorGalleryController::class, 'index'])->name('index');
		Route::get('/category/{slug}', [InteriorGalleryController::class, 'category'])->name('category');
		Route::get('/{slug}', [InteriorGalleryController::class, 'show'])->name('show');
	});

	// HTML Sitemap
	Route::get('/sitemap', [SitemapController::class, 'html'])->name('sitemap.html');

	// Favourites
	Route::prefix('favourites')->group(function () {
		Route::get('/', [FavouriteController::class, 'index'])->name('favourites.index');
		Route::post('/toggle', [FavouriteController::class, 'toggle'])->name('favourites.toggle')->middleware('throttle:60,1');
		Route::delete('/clear/all', [FavouriteController::class, 'clear'])->name('favourites.clear')->middleware('throttle:30,1');
		Route::get('/count', [FavouriteController::class, 'count'])->name('favourites.count');
		Route::get('/shared/{token}', [FavouriteController::class, 'shared'])->name('favourites.shared');
		// Sends branded mail from our own SMTP relay to a caller-supplied address, so this
		// is kept deliberately tight - it was an unauthenticated open relay before.
		Route::post('/send-email', [FavouriteController::class, 'sendEmail'])->name('favourites.sendEmail')->middleware('throttle:3,60');
		Route::delete('/{id}', [FavouriteController::class, 'remove'])->name('favourites.remove')->middleware('throttle:30,1');
	});

});

// Sitemap Route (outside localization group for clean URL)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Analytics heartbeat (CSRF-exempt, outside localization)
Route::post('/analytics/heartbeat', AnalyticsHeartbeatController::class)
    ->name('analytics.heartbeat')
    ->middleware('throttle:heartbeat');

// ============================================
// FALLBACK: Catch all undefined routes - return 404
// This must be at the end of the routes file
// ============================================
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function() {
    Route::fallback(function () {
        abort(404);
    });
});
