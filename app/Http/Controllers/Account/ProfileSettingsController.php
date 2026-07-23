<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Requests\Account\PreferencesRequest;
use App\Http\Requests\Account\ProfileDetailsRequest;
use App\Mail\CustomerEmailChangeMail;
use App\Models\PageBanner;
use App\Models\User;
use App\Services\CustomerSync\CustomerSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProfileSettingsController extends Controller
{
    public function __construct(protected CustomerSyncService $sync)
    {
    }

    /**
     * Show the tabbed settings page.
     */
    public function edit()
    {
        return view('pages.account.settings', [
            'user' => auth()->user(),
            'pageBanner' => PageBanner::getByTarget('account'),
        ]);
    }

    /**
     * Update name/phone; an email change is deferred until verified on the new address.
     */
    public function updateDetails(ProfileDetailsRequest $request)
    {
        $user = $request->user();
        $user->name = $request->name;
        $user->phone = $request->phone;

        $emailChanged = $request->email !== $user->email;

        if ($emailChanged) {
            $token = Str::random(64);
            $user->pending_email = $request->email;
            $user->pending_email_token = $token;
        }

        $user->save();

        if ($emailChanged) {
            $url = URL::temporarySignedRoute(
                'account.email.verify',
                now()->addHours(24),
                ['token' => $token]
            );

            try {
                Mail::to($user->pending_email)->send(new CustomerEmailChangeMail($user, $url, $user->pending_email));
            } catch (\Throwable $e) {
                Log::warning('Email-change verification mail failed: ' . $e->getMessage());
            }
        }

        $this->pushSync($user);

        $message = $emailChanged
            ? __('lang.account_email_change_requested')
            : __('lang.account_details_updated');

        return redirect()->route('account.settings')->with('success', $message);
    }

    /**
     * Change the account password (requires the current password).
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->password_set_at = now();
        $user->save();

        return redirect()->route('account.settings')->with('success', __('lang.account_password_updated'));
    }

    /**
     * Update locale + notification preferences.
     */
    public function updatePreferences(PreferencesRequest $request)
    {
        $user = $request->user();
        $user->preferred_locale = $request->preferred_locale;
        $user->notification_prefs = [
            'email_updates' => $request->boolean('notify_email_updates'),
            'project_updates' => $request->boolean('notify_project_updates'),
        ];
        $user->save();

        $this->pushSync($user);

        return redirect()->route('account.settings')->with('success', __('lang.account_preferences_updated'));
    }

    /**
     * Confirm a pending email change via the signed link sent to the new address.
     */
    public function verifyNewEmail(Request $request)
    {
        $user = $request->user();
        $token = (string) $request->route('token');

        $valid = $user->pending_email
            && $user->pending_email_token
            && hash_equals($user->pending_email_token, $token);

        // Guard against the address being taken since the request was made.
        $taken = $valid && User::where('email', $user->pending_email)
            ->where('id', '!=', $user->id)
            ->exists();

        if (!$valid || $taken) {
            return redirect()->route('account.settings')->with('error', __('lang.account_email_change_invalid'));
        }

        $user->email = $user->pending_email;
        $user->email_verified_at = now();
        $user->pending_email = null;
        $user->pending_email_token = null;
        $user->save();

        $this->pushSync($user);

        return redirect()->route('account.profile')->with('success', __('lang.account_email_changed'));
    }

    /**
     * Deferred-ERP hook (no-op today via NullCustomerSyncService).
     */
    protected function pushSync(User $user): void
    {
        try {
            $this->sync->pushProfileUpdate($user);
        } catch (\Throwable $e) {
            Log::warning('Customer sync pushProfileUpdate failed: ' . $e->getMessage());
        }
    }
}
