<header id="page-topbar">
    <link rel="icon" type="image/x-icon" href="{{URL('client/images/favicon.ico')}}">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                {{-- <div class="navbar-brand-box horizontal-logo">
                    <a href="#" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" height="17">
                        </span>
                    </a>
                </div> --}}

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle avatar-xs" width="40"
                            src="{{ !empty(auth()->user()->photo) ? url('/storage/account/' . auth()->user()->photo) : "
                            https://ui-avatars.com/api/?name=" . auth()->user()->name }}" />
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{
                                    auth()->user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{
                                    Str::ucfirst(auth()->user()->level) }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                        <a href="{{ route('account.index') }}" class="dropdown-item"><i
                                class="mdi mdi-account text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-account">Account</span></a>
                        <a href="javascript:void(0)">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button class="dropdown-item" type="submit"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                                    <span class="align-middle" data-key="t-logout">Logout</span></button>
                            </form>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>