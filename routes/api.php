<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ErpWebhookController;
use App\Http\Controllers\Api\V1\CustomerAuthController;
use App\Http\Controllers\Api\V1\DevController;
use App\Http\Controllers\Api\V1\CustomerPasswordController;
use App\Http\Controllers\Api\V1\CustomerProfileController;
use App\Http\Controllers\Api\V1\Public\MenuItemsController;
// use App\Http\Controllers\Api\V1\Public\ProjectsController;
// use App\Http\Controllers\Api\V1\Public\OffersController;
// use App\Http\Controllers\Api\V1\Public\InteriorController;
use App\Http\Controllers\Api\V1\Public\ContactController;
use App\Http\Controllers\Api\V1\CustomerFavouriteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Mobile app API - v1
Route::prefix('v1')->group(function () {
    // Customer authentication
    Route::prefix('customer')->group(function () {
        Route::post('/register', [CustomerAuthController::class, 'register'])->middleware('throttle:5,1');
        Route::post('/login', [CustomerAuthController::class, 'login'])->middleware('throttle:10,1');
        Route::post('/forgot-password', [CustomerPasswordController::class, 'forgotPassword'])->middleware('throttle:5,1');
        Route::post('/reset-password', [CustomerPasswordController::class, 'resetPassword'])->middleware('throttle:6,1');
        Route::post('/resend-activation', [CustomerPasswordController::class, 'resendActivation'])->middleware('throttle:5,1');

        Route::middleware(['auth:sanctum', 'ability:customer:read'])->group(function () {
            Route::get('/me', [CustomerAuthController::class, 'me']);
            Route::post('/logout', [CustomerAuthController::class, 'logout']);
            Route::get('/profile', [CustomerProfileController::class, 'show']);
        });

        Route::middleware(['auth:sanctum', 'ability:customer:write'])->group(function () {
            Route::put('/profile', [CustomerProfileController::class, 'update']);
            Route::put('/password', [CustomerProfileController::class, 'updatePassword']);
        });
    });

    Route::prefix('contact')->group(function () {
        Route::post('/', [ContactController::class, 'store'])->middleware('throttle:5,1');
    });

    Route::prefix('favourites')->group(function () {
        Route::middleware(['auth:sanctum', 'ability:customer:read'])->group(function () {
            Route::get('/', [CustomerFavouriteController::class, 'index']);
            Route::get('/count', [CustomerFavouriteController::class, 'count']);
        });

        Route::middleware(['auth:sanctum', 'ability:customer:write'])->group(function () {
            Route::post('/toggle/{item_type}/{item_id}', [CustomerFavouriteController::class, 'toggle'])
                ->where('item_id', '[0-9]+');
            Route::delete('/{id}', [CustomerFavouriteController::class, 'remove']);
            Route::delete('/', [CustomerFavouriteController::class, 'clear']);
        });
    });

    Route::prefix('items')->group(function () {
        Route::get('/', [MenuItemsController::class, 'index']);
        Route::get('/route', [MenuItemsController::class, 'itemRoute']);
        Route::get('/detail', [MenuItemsController::class, 'itemDetail']);
    });
});

// Local-only testing helper: reset rate-limit/cooldown keys for an email from
// Apidog/Postman directly. The route itself only exists when APP_ENV=local -
// it is never registered, so never reachable, in staging/production.
if (app()->environment('local')) {
    Route::prefix('v1/dev')->group(function () {
        Route::post('/reset-throttle', [DevController::class, 'resetThrottle']);
    });
}

// ERPNext inbound webhook (HMAC-verified). Returns 404 while the integration is
// disabled; guarded by an HMAC signature check inside the controller (no session).
// Server-to-server integration, not a mobile-app endpoint - stays outside v1.
Route::prefix('erp')->group(function () {
    Route::post('/webhook/customer', [ErpWebhookController::class, 'customer'])->middleware('throttle:60,1');
});

// Any /api/* path that doesn't match a route above must 404 cleanly as JSON (via
// Handler::shouldReturnJson). Without this, an unmatched path falls through to
// routes/web.php's locale-redirect middleware, which 302s it to the site homepage
// instead of erroring - looks like "nothing happened" to an API client and gives
// no clue what went wrong.
Route::fallback(function () {
    abort(404, 'No API route matches this path/method.');
});
