<ul class="menu-aside">
    <li class="menu-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.home') }}">
            <i class="icon material-icons md-home"></i>
            <span class="text">لوحة التحكم</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.companies.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.companies.index') }}">
            <i class="icon material-icons md-shopping_cart"></i>
            <span class="text">شركات التوصيل</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.branch_managers.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.branch_managers.index') }}">
            <i class="icon material-icons md-supervised_user_circle"></i>
            <span class="text">مدراء الأفرع (البراندات)</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.branches.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.branches.index') }}">
            <i class="icon material-icons md-storefront"></i>
            <span class="text">الأفرع</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.orders.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.orders.index') }}">
            <i class="icon material-icons md-receipt_long"></i>
            <span class="text">الطلبات</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.subscription_packages.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.subscription_packages.index') }}">
            <i class="icon material-icons md-reorder"></i>
            <span class="text">خطط الاشتراك</span>
        </a>
    </li>
</ul>
