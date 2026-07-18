{{-- Account hero + breadcrumb.
     Expects: $title (string), $subtitle (string|null), $guest (bool|null - hide the authed "Account" crumb) --}}
@php $guest = $guest ?? false; @endphp
<section class="account-hero">
    <div class="container">
        <div class="text-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('lang.account_home') }}</a></li>
                    @unless($guest)
                    <li class="breadcrumb-item"><a href="{{ route('account.dashboard') }}">{{ __('lang.account') }}</a></li>
                    @endunless
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
            <h1 class="account-hero-title">{{ $title }}</h1>
            @if(!empty($subtitle))
                <p class="account-hero-subtitle">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
</section>
