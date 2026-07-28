<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\CustomerProfileController;
use App\Http\Controllers\Api\ErpWebhookController;

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

// Returns an explicit field list, not the model. It used to return $request->user()
// wholesale, which serialised pending_email_token, favourites_token, the ERP ids and the
// assigned agent — and it was the only Sanctum route with no ability gate, so a token
// deliberately scoped to read-only still saw everything.
Route::middleware(['auth:sanctum', 'ability:customer:read'])->get('/user', function (Request $request) {
    $user = $request->user();

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'preferred_locale' => $user->preferred_locale,
    ]);
});

// Mobile app - customer authentication
Route::prefix('customer')->group(function () {
    Route::post('/register', [CustomerAuthController::class, 'register'])->middleware('throttle:5,1');
    Route::post('/login', [CustomerAuthController::class, 'login'])->middleware('throttle:10,1');

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

// ERPNext inbound webhook (HMAC-verified). Returns 404 while the integration is
// disabled; guarded by an HMAC signature check inside the controller (no session).
Route::prefix('erp')->group(function () {
    Route::post('/webhook/customer', [ErpWebhookController::class, 'customer'])->middleware('throttle:60,1');
});
