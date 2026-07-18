@extends('layouts.master')
@section('title', __('lang.account_set_password_title'))
@section('seo_desc', __('lang.account_set_password_subtitle'))
@section('robots', 'noindex, nofollow')

@section('css')
<link rel="stylesheet" href="{{ asset('/assets/css/account-portal.css') }}?v={{ filemtime(public_path('assets/css/account-portal.css')) }}">
@endsection

@section('content')
@include('pages.account.partials.hero', [
    'title' => __('lang.account_set_password_title'),
    'subtitle' => __('lang.account_set_password_subtitle'),
    'guest' => true,
])

<section class="account-section">
    <div class="container">
        <div class="account-auth-wrap">
            <div class="account-card">
                <h2 class="account-card__title">{{ __('lang.account_set_password_title') }}</h2>
                <p class="account-card__subtitle">{{ __('lang.account_set_password_subtitle') }}</p>

                <form method="POST" action="{{ route('account.password.update') }}" class="account-form" id="setPasswordForm">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">{{ __('lang.account_email') }}</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $email) }}" class="form-control @error('email') is-invalid @enderror" required readonly>
                        @error('email')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="password">{{ __('lang.account_password') }}</label>
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

                    <button type="submit" class="btn btn-account w-100">
                        <i class="fas fa-check-circle mr-2"></i> {{ __('lang.account_activate_account') }}
                    </button>
                </form>
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
    var form = document.getElementById('setPasswordForm');
    if (!form) { return; }
    form.addEventListener('submit', function (e) {
        var pw = document.getElementById('password');
        var confirm = document.getElementById('password_confirmation');
        if (pw.value !== confirm.value) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: 'error', title: @json(__('lang.error')), text: @json(__('lang.account_confirm_password')), confirmButtonColor: '#e1273d' });
            }
        }
    });
})();
</script>
@endsection
