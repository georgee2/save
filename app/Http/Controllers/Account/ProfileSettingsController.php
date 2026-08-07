<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Requests\Account\PreferencesRequest;
use App\Http\Requests\Account\ProfileDetailsRequest;
use App\Models\PageBanner;
use App\Models\User;
use App\Services\CustomerSync\CustomerSyncService;
use App\Services\EmailChangeService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileSettingsController extends Controller
{
    public function __construct(
        protected CustomerSyncService $sync,
        protected EmailChangeService $emailChange,
    ) {
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

        $emailChanged = $request->emailIsChanging();

        $user->save();

        if ($emailChanged) {
            // Stores a hashed token with a server-side expiry, mails the new address a
            // confirmation link and warns the old one. Shared with the API, which had its
            // own drifting copy of this.
            $this->emailChange->start($user, $request->email);
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

        // Must come AFTER the save: logoutOtherDevices verifies the password it is given
        // against the stored hash and throws if it does not match, so it takes the NEW
        // password once that password is the current one. It then re-hashes and updates
        // the hash AuthenticateSession keeps per session, which is what invalidates every
        // other device while leaving this one signed in.
        Auth::logoutOtherDevices($request->password);

        // Revokes outstanding reset and invitation links, every API token, and the
        // remember-me cookie. Previously none of that happened, so a user changing their
        // password after a compromise did not actually evict the attacker.
        event(new PasswordReset($user));

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

        if (!$this->emailChange->confirm($user, $token)) {
            return redirect()->route('account.settings')->with('error', __('lang.account_email_change_invalid'));
        }

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
