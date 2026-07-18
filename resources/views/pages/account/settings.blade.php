@extends('layouts.master')
@section('title', __('lang.account_settings_title'))
@section('seo_desc', __('lang.account_portal_subtitle'))
@section('robots', 'noindex, nofollow')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/account-portal.css') }}?v={{ filemtime(public_path('assets/css/account-portal.css')) }}">
@endsection

@section('content')
@php
    $prefs = $user->notification_prefs ?? [];
    $emailUpdates = array_key_exists('email_updates', $prefs) ? $prefs['email_updates'] : true;
    $projectUpdates = array_key_exists('project_updates', $prefs) ? $prefs['project_updates'] : true;
    $currentLocale = $user->preferred_locale ?? app()->getLocale();

    // Re-open the tab that failed validation.
    $errKeys = array_keys($errors->messages());
    $activeTab = 'details';
    if (array_intersect($errKeys, ['current_password', 'password'])) {
        $activeTab = 'password';
    } elseif (array_intersect($errKeys, ['preferred_locale', 'notify_email_updates', 'notify_project_updates'])) {
        $activeTab = 'preferences';
    }
@endphp

@include('pages.account.partials.hero', [
    'title' => __('lang.account_settings_title'),
    'subtitle' => __('lang.account_portal_subtitle'),
])

<section class="account-section">
    <div class="container">
        <div class="account-grid">
            @include('pages.account.partials.nav')

            <div>
                @if ($user->pending_email)
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-clock mr-2"></i>
                        {{ __('lang.account_pending_email_notice', ['email' => $user->pending_email]) }}
                    </div>
                @endif

                <div class="account-card">
                    <div class="account-tabs" role="tablist">
                        <button type="button" class="account-tabs__btn {{ $activeTab === 'details' ? 'is-active' : '' }}" data-tab="details" role="tab">{{ __('lang.account_tab_details') }}</button>
                        <button type="button" class="account-tabs__btn {{ $activeTab === 'password' ? 'is-active' : '' }}" data-tab="password" role="tab">{{ __('lang.account_tab_password') }}</button>
                        <button type="button" class="account-tabs__btn {{ $activeTab === 'preferences' ? 'is-active' : '' }}" data-tab="preferences" role="tab">{{ __('lang.account_tab_preferences') }}</button>
                    </div>

                    {{-- Details --}}
                    <div class="account-tab-pane {{ $activeTab === 'details' ? 'is-active' : '' }}" id="tab-details" role="tabpanel">
                        <form method="POST" action="{{ route('account.settings.details') }}" class="account-form" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ __('lang.account_full_name') }}</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ __('lang.account_email') }}</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">{{ __('lang.account_phone_optional') }}</label>
                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                @error('phone')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <button type="submit" class="btn btn-account"><i class="fas fa-save mr-2"></i> {{ __('lang.account_update_details') }}</button>
                        </form>
                    </div>

                    {{-- Password --}}
                    <div class="account-tab-pane {{ $activeTab === 'password' ? 'is-active' : '' }}" id="tab-password" role="tabpanel">
                        <form method="POST" action="{{ route('account.settings.password') }}" class="account-form" id="passwordForm" novalidate>
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="current_password">{{ __('lang.account_current_password') }}</label>
                                <div class="account-pw">
                                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
                                    <button type="button" class="pw-toggle" data-target="current_password" aria-label="Show password"><i class="fa fa-eye"></i></button>
                                </div>
                                @error('current_password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('lang.account_new_password') }}</label>
                                <div class="account-pw">
                                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8" autocomplete="new-password">
                                    <button type="button" class="pw-toggle" data-target="password" aria-label="Show password"><i class="fa fa-eye"></i></button>
                                </div>
                                <small class="form-text text-muted">{{ __('lang.account_password_hint') }}</small>
                                @error('password')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">{{ __('lang.account_confirm_password') }}</label>
                                <div class="account-pw">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="8" autocomplete="new-password">
                                    <button type="button" class="pw-toggle" data-target="password_confirmation" aria-label="Show password"><i class="fa fa-eye"></i></button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-account"><i class="fas fa-key mr-2"></i> {{ __('lang.account_change_password') }}</button>
                        </form>
                    </div>

                    {{-- Preferences --}}
                    <div class="account-tab-pane {{ $activeTab === 'preferences' ? 'is-active' : '' }}" id="tab-preferences" role="tabpanel">
                        <form method="POST" action="{{ route('account.settings.preferences') }}" class="account-form">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="preferred_locale">{{ __('lang.account_preferred_language') }}</label>
                                <select id="preferred_locale" name="preferred_locale" class="form-control @error('preferred_locale') is-invalid @enderror">
                                    <option value="en" {{ $currentLocale === 'en' ? 'selected' : '' }}>{{ __('lang.account_language_en') }}</option>
                                    <option value="ar" {{ $currentLocale === 'ar' ? 'selected' : '' }}>{{ __('lang.account_language_ar') }}</option>
                                </select>
                                @error('preferred_locale')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('lang.account_notifications') }}</label>
                                <label class="account-check">
                                    <input type="checkbox" name="notify_email_updates" value="1" {{ $emailUpdates ? 'checked' : '' }}>
                                    <span>{{ __('lang.account_notify_email_updates') }}</span>
                                </label>
                                <label class="account-check">
                                    <input type="checkbox" name="notify_project_updates" value="1" {{ $projectUpdates ? 'checked' : '' }}>
                                    <span>{{ __('lang.account_notify_project_updates') }}</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-account"><i class="fas fa-save mr-2"></i> {{ __('lang.account_update_preferences') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@include('pages.account.partials.alerts')
@include('pages.account.partials.password-toggle')
<script>
(function () {
    var tabs = document.querySelectorAll('.account-tabs__btn');
    var panes = document.querySelectorAll('.account-tab-pane');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('is-active'); });
            panes.forEach(function (p) { p.classList.remove('is-active'); });
            tab.classList.add('is-active');
            var pane = document.getElementById('tab-' + tab.getAttribute('data-tab'));
            if (pane) { pane.classList.add('is-active'); }
        });
    });

    // Client-side: confirm the two new passwords match before submitting.
    var pwForm = document.getElementById('passwordForm');
    if (pwForm) {
        pwForm.addEventListener('submit', function (e) {
            var pw = document.getElementById('password');
            var confirm = document.getElementById('password_confirmation');
            if (pw.value !== confirm.value) {
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: @json(__('lang.error')), text: @json(__('lang.account_confirm_password')), confirmButtonColor: '#e1273d' });
                }
            }
        });
    }
})();
</script>
@endsection
