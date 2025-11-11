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
</ul>
