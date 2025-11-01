<ul class="menu-aside">
    <li class="menu-item {{ request()->routeIs('dashboard.home') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.home') }}">
            <i class="icon material-icons md-home"></i>
            <span class="text">الرئيسية</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.branches.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.branches.index') }}">
            <i class="icon material-icons md-store"></i>
            <span class="text">الأفرع الخاصة بي</span>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.orders.index') ? 'active' : '' }}">
        <a class="menu-link" href="{{ route('dashboard.orders.index') }}">
            <i class="icon material-icons md-receipt_long"></i>
            <span class="text">الطلبات</span>
        </a>
    </li>
</ul>
