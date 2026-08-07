<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\TimingGuard;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class StaffPasswordController extends Controller
{
    /**
     * Show the staff set-password form (reached from the reset email link).
     */
    public function showForm(Request $request)
    {
        // Always show the form: in the self-service flow the staff member is typically
        // still logged in when they open the reset link, so we must not redirect away.
        return view('auth.staff-reset-password', [
            'token' => $request->route('token'),
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Consume the reset token and set a new password for a staff account.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            // regex restricts to printable ASCII (no Arabic / non-Latin characters).
            'password' => ['required', 'string', 'confirmed', 'regex:/^[\x20-\x7E]+$/', PasswordRule::defaults()],
        ], [
            'password.regex' => __('lang.account_password_english_only'),
        ]);

        // Only staff accounts may reset via this endpoint.
        $user = User::where('email', Str::lower(trim($request->email)))->first();
        if (!$user || !$user->isStaff()) {
            // Timing is balanced with the success path below, which bcrypt-verifies the
            // token, so a rejection here does not answer faster than a real attempt.
            TimingGuard::burnPasswordHash();

            return $this->invalidLink($request);
        }

        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');

        $status = Password::broker()->reset($credentials, function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'password_set_at' => now(),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });

        if ($status !== Password::PASSWORD_RESET) {
            return $this->invalidLink($request);
        }

        // If the staff member was still logged in (typical for the self-service flow),
        // end the current session so they must sign in again with the new password.
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('success', __('lang.staff_reset_success'));
    }

    /**
     * One response for every failure mode.
     *
     * This endpoint used to return passwords.user ("we can't find a user with that email")
     * when the address was unknown OR belonged to a customer, and passwords.token when it
     * belonged to staff - an unauthenticated oracle for both account existence and which
     * addresses are staff. Mirrors CustomerPasswordController::invalidLink.
     */
    private function invalidLink(Request $request)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => __('lang.account_reset_link_invalid')]);
    }
}
