<ul class="menu-aside">
    <li class="menu-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.home') }}">
            <i class="icon material-icons md-home"></i>
            <span class="text">الرئيسية</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.orders.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.orders.index') }}">
            <i class="icon material-icons md-receipt_long"></i>
            <span class="text">طلباتي</span>
        </a>
    </li>
</ul>
