<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CustomerEmailChangeMail;
use App\Models\User;
use App\Services\CustomerSync\CustomerSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CustomerProfileController extends Controller
{
    public function __construct(protected CustomerSyncService $sync)
    {
    }

    /**
     * Return the authenticated customer's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'pending_email' => $user->pending_email,
            'phone' => $user->phone,
            'preferred_locale' => $user->preferred_locale,
            'notification_prefs' => $user->notification_prefs,
            'email_verified' => (bool) $user->email_verified_at,
        ]);
    }

    /**
     * Update details + preferences. Email changes require verification on the new address.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'email' => [
                'sometimes', 'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('users', 'pending_email')->ignore($user->id),
            ],
            'preferred_locale' => ['sometimes', 'required', Rule::in(['en', 'ar'])],
            'notification_prefs' => ['sometimes', 'array'],
        ])->validate();

        if (array_key_exists('name', $data)) {
            $user->name = $data['name'];
        }
        if (array_key_exists('phone', $data)) {
            $user->phone = $data['phone'];
        }
        if (array_key_exists('preferred_locale', $data)) {
            $user->preferred_locale = $data['preferred_locale'];
        }
        if (array_key_exists('notification_prefs', $data)) {
            $user->notification_prefs = $data['notification_prefs'];
        }

        $emailChanged = false;
        if (array_key_exists('email', $data)) {
            $newEmail = Str::lower(trim($data['email']));
            if ($newEmail !== $user->email) {
                $emailChanged = true;
                $token = Str::random(64);
                $user->pending_email = $newEmail;
                $user->pending_email_token = $token;
            }
        }

        $user->save();

        if ($emailChanged) {
            $url = URL::temporarySignedRoute('account.email.verify', now()->addHours(24), ['token' => $token]);
            try {
                Mail::to($user->pending_email)->send(new CustomerEmailChangeMail($user, $url, $user->pending_email));
            } catch (\Throwable $e) {
                Log::warning('API email-change verification mail failed: ' . $e->getMessage());
            }
        }

        try {
            $this->sync->pushProfileUpdate($user);
        } catch (\Throwable $e) {
            Log::warning('Customer sync pushProfileUpdate (API) failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'email_change_pending' => $emailChanged,
        ]);
    }

    /**
     * Change the account password (requires the current password).
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => ['required', 'current_password:sanctum'],
            // regex restricts to printable ASCII (no Arabic / non-Latin characters).
            'password' => ['required', 'string', 'confirmed', 'regex:/^[\x20-\x7E]+$/', Password::defaults()],
        ], [
            'password.regex' => __('lang.account_password_english_only'),
        ]);

        $user->password = Hash::make($request->password);
        $user->password_set_at = now();
        $user->save();

        return response()->json(['success' => true]);
    }
}
