@extends('layouts.master')
@section('title', __('lang.account_register_title'))
@section('seo_desc', __('lang.account_register_subtitle'))

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/account-portal.css') }}?v={{ filemtime(public_path('assets/css/account-portal.css')) }}">
@endsection

@section('content')
@include('pages.account.partials.hero', [
    'title' => __('lang.account_register_title'),
    'subtitle' => __('lang.account_register_subtitle'),
    'guest' => true,
])

<section class="account-section">
    <div class="container">
        <div class="account-auth-wrap">
            <div class="account-card">
                <h2 class="account-card__title">{{ __('lang.account_register_title') }}</h2>
                <p class="account-card__subtitle">{{ __('lang.account_register_subtitle') }}</p>

                <form method="POST" action="{{ route('account.register.submit') }}" class="account-form" id="registerForm">
                    @csrf
                    @include('includes.form-guard')
                    @if(!empty($recaptchaEnabled))
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    @endif

                    <div class="form-group">
                        <label for="name">{{ __('lang.account_full_name') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('lang.account_email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">{{ __('lang.account_phone_optional') }}</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                    <label class="account-check">
                        <input type="checkbox" name="consent" value="1" id="consent" required>
                        <span>{{ __('lang.account_consent') }}</span>
                    </label>
                    @error('consent')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror

                    <button type="submit" class="btn btn-account w-100 mt-3">
                        <i class="fas fa-user-plus mr-2"></i> {{ __('lang.account_create_account') }}
                    </button>
                </form>

                <p class="text-center mt-4 mb-0">
                    {{ __('lang.account_have_account') }}
                    <a href="{{ route('login') }}" style="color:var(--acc-primary);font-weight:600;">{{ __('lang.account_login') }}</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
@include('pages.account.partials.alerts')
@if(!empty($recaptchaEnabled))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
<script>
(function () {
    var form = document.getElementById('registerForm');
    var field = document.getElementById('g-recaptcha-response');
    if (!form) { return; }

    var submitting = false;
    form.addEventListener('submit', function (e) {
        if (submitting) { return; }
        e.preventDefault();

        // Always submit, even if reCAPTCHA fails to load or execute, so the user
        // gets server-side feedback instead of a silently blocked form.
        var proceed = function () { submitting = true; form.submit(); };

        try {
            if (typeof grecaptcha === 'undefined') { return proceed(); }
            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'register' })
                    .then(function (token) { if (field) { field.value = token; } proceed(); })
                    .catch(function () { proceed(); });
            });
        } catch (err) {
            proceed();
        }
    });
})();
</script>
@endif
@endsection
