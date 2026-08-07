{{-- Account sidebar navigation. Highlights the active route. --}}
@php $user = auth()->user(); @endphp
<aside class="account-nav" aria-label="{{ __('lang.account') }}">
    <div class="account-nav__head">
        <p class="account-nav__name">{{ $user->name }}</p>
        <p class="account-nav__email">{{ $user->email }}</p>
    </div>
    <ul class="account-nav__list">
        <li>
            <a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs('account.dashboard') ? 'is-active' : '' }}">
                <i class="fas fa-th-large"></i> {{ __('lang.account_dashboard') }}
            </a>
        </li>
        <li>
            <a href="{{ route('account.profile') }}" class="{{ request()->routeIs('account.profile') ? 'is-active' : '' }}">
                <i class="fas fa-user"></i> {{ __('lang.account_profile') }}
            </a>
        </li>
        <li>
            <a href="{{ route('account.favourites') }}" class="{{ request()->routeIs('account.favourites') ? 'is-active' : '' }}">
                <i class="fas fa-heart"></i> {{ __('lang.account_favourites') }}
            </a>
        </li>
        <li>
            <a href="{{ route('account.settings') }}" class="{{ request()->routeIs('account.settings') ? 'is-active' : '' }}">
                <i class="fas fa-cog"></i> {{ __('lang.account_settings') }}
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="is-danger">
                <i class="fas fa-sign-out-alt"></i> {{ __('lang.account_logout') }}
            </a>
        </li>
    </ul>
</aside>
