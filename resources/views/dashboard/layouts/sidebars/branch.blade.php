<ul class="menu-aside">
    <li class="menu-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.home') }}">
            <i class="icon material-icons md-home"></i>
            <span class="text">{{ __('dashboard.home') }}</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.orders.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.orders.index') }}">
            <i class="icon material-icons md-receipt_long"></i>
            <span class="text">{{ __('dashboard.my_orders') }}</span>
        </a>
    </li>
    <hr>
    <ul class="menu-aside">
        <li class="menu-item {{ request()->routeIs('dashboard.account.index') ? 'active' : '' }}">
            <a class="menu-link" href="{{ route('dashboard.account.index') }}">
                <i class="icon material-icons md-account_circle"></i>
                <span class="text">{{ __('dashboard.my_account') }}</span>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.reset-password') ? 'active' : '' }}">
            <a class="menu-link" href="{{ route('dashboard.reset-password') }}">
                <i class="icon material-icons md-vpn_key"></i>
                <span class="text">{{ __('dashboard.change_password') }}</span>
            </a>
        </li>
    </ul>

</ul>
