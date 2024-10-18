<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Light Logo-->
        {{-- <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a> --}}
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-dashboard-data">Dashboard</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                @if (auth()->user()->level == 'driver')
                <li class="menu-title"><span data-key="t-pickup-data">Pick Up</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('pickup.*') ? 'active' : '' }}"
                        href="{{ route('pickup.index') }}">
                        <i class="ri-truck-line"></i> <span data-key="t-pickup">Pick Up</span>
                    </a>
                </li>
                @endif

                @if (auth()->user()->level == 'admin')
                <li class="menu-title"><span data-key="t-master">Master Data</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                        href="{{ route('admin.index') }}">
                        <i class="ri-user-line"></i> <span data-key="t-admin">Admin & Driver</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('product.*') ? 'active' : '' }}"
                        href="{{ route('product.index') }}">
                        <i class="ri-database-2-line"></i> <span data-key="t-product">Master Product</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('reward.*') ? 'active' : '' }}"
                        href="{{ route('reward.index') }}">
                        <i class="ri-award-fill"></i> <span data-key="t-reward">Master Reward</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{  request()->routeIs('customer.*') ? 'active' : '' }}"
                        href="{{ route('customer.index') }}">
                        <i class="ri-team-line"></i> <span data-key="t-customer">Customer Data</span>
                    </a>
                </li>

                <li class="menu-title"><span data-key="t-order">Order</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('order.*') ? 'active' : '' }}"
                        href="{{ route('order.index') }}">
                        <i class="ri-shopping-cart-line"></i> <span data-key="t-order">Order</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('user-reward.*') ? 'active' : '' }}"
                        href="{{ route('user-reward.index') }}">
                        <i class="ri-coin-line"></i> <span data-key="t-user-reward">User Reward</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>