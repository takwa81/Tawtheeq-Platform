<ul class="menu-aside">
    <li class="menu-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.home') }}">
            <i class="icon material-icons md-home"></i>
            <span class="text">{{ __('dashboard.home') }}</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.companies.*') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.companies.index') }}">
            <i class="icon material-icons md-shopping_cart"></i>
            <span class="text">{{ __('dashboard.delivery_companies') }}</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.branch_managers.*') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.branch_managers.index') }}">
            <i class="icon material-icons md-supervised_user_circle"></i>
            <span class="text">{{ __('dashboard.branch_managers') }}</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.branches.*') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.branches.index') }}">
            <i class="icon material-icons md-storefront"></i>
            <span class="text">{{ __('dashboard.branches') }}</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.orders.*') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.orders.index') }}">
            <i class="icon material-icons md-receipt_long"></i>
            <span class="text">{{ __('dashboard.orders') }}</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.subscription_packages.*') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.subscription_packages.index') }}">
            <i class="icon material-icons md-reorder"></i>
            <span class="text">{{ __('dashboard.subscription_packages') }}</span>
        </a>
    </li>
    <li class="menu-item {{ request()->routeIs('dashboard.subscriptions.*') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.subscriptions.index') }}">
            <i class="icon material-icons md-card_membership"></i>
            <span class="text">{{ __('dashboard.subscriptions') }}</span>
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
