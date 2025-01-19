<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard.index') }}" class="app-brand-link h-100">
            <img class="sidebar-logo w-100 h-100 object-fit-contain" src="{{ asset('assets/img/logo.jpg') }}"
                alt="">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @if ($user_role == 1)
            <li class="menu-item {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-smile"></i>
                    <div class="text-truncate" data-i18n="Email">Dashboards</div>
                </a>
            </li>
        @endif

        @if ($user_role != 3)
        <li class="menu-item {{ request()->routeIs('admin.agents.index') && request('role') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Dashboards">Users</div>
            </a>
            <ul class="menu-sub">
                @if ($user_role == 1)
                    <li
                        class="menu-item {{ request()->routeIs('admin.agents.index') && request('role') === 'agent' ? 'active' : '' }}">
                        <a href="{{ route('admin.agents.index', ['role' => 'agent']) }}" class="menu-link">
                            <div class="text-truncate" data-i18n="Agent">Agent</div>
                        </a>
                    </li>
                @endif
                @if ($user_role == 1 || $user_role == 2)
                    <li
                        class="menu-item {{ request()->routeIs('admin.agents.index') && request('role') === 'sub-agent' ? 'active' : '' }}">
                        <a href="{{ route('admin.agents.index', ['role' => 'sub-agent']) }}" class="menu-link">
                            <div class="text-truncate" data-i18n="Sub Agent">Sub Agent</div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        @endif

        <li class="menu-item {{ request()->routeIs('admin.passengers.index') ? 'active' : '' }}">
            <a href="{{ route('admin.passengers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Email">Passengers</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.accounts.index') ? 'active' : '' }}">
            <a href="{{ route('admin.accounts.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Email">Accounts</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
