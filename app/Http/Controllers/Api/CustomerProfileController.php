<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CustomerEmailChangeMail;
use App\Models\User;
use App\Services\CustomerSync\CustomerSyncService;
use App\Services\EmailChangeService;
use Illuminate\Auth\Events\PasswordReset;
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
    public function __construct(
        protected CustomerSyncService $sync,
        protected EmailChangeService $emailChange,
    ) {
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

        $emailIsChanging = $request->has('email')
            && Str::lower(trim((string) $request->input('email'))) !== $user->email;

        $data = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'email' => [
                'sometimes', 'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('users', 'pending_email')->ignore($user->id),
            ],
            // Matches the web form: redirecting the account's email is the first move in
            // taking it over, so it needs the password and not just a valid token.
            'current_password' => $emailIsChanging
                ? ['required', 'current_password:sanctum']
                : ['sometimes'],
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

        $user->save();

        // Shared with the web flow rather than duplicated here: this copy had already
        // drifted, storing the token in plaintext with no server-side expiry and never
        // warning the address that was losing control of the account.
        if ($emailIsChanging) {
            $this->emailChange->start($user, Str::lower(trim((string) $request->input('email'))));
        }

        $emailChanged = $emailIsChanging;

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

        // Revokes outstanding reset and invitation links and every existing API token,
        // including the one used for this request - a token issued under the old password
        // must not outlive it. Nothing was revoked here before.
        event(new PasswordReset($user));

        // The caller just proved it knows the new password, so hand back a working token
        // rather than silently signing the app out.
        $token = $user->createToken(
            $request->input('device_name', 'mobile-app'),
            ['customer:read', 'customer:write']
        );

        return response()->json([
            'success' => true,
            'token' => $token->plainTextToken,
        ]);
    }
}
