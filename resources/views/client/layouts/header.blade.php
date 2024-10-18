<header id="header" data-transparent="true" data-fullwidth="true" class="submenu-light">
    <link rel="icon" type="image/x-icon" href="{{URL('client/images/favicon.ico')}}">
    <div class="header-inner">
        <div class="container">
            <!--Logo-->
            <div id="logo">
                <a href="{{ route('client.home.index') }}">
                    <span class="logo-default" ><img width="80" src="{{ asset('client/images/logo-without-bg.png') }}" alt=""></span>
                    <span class="logo-dark">CLOAK</span>
                </a>
            </div>

            @auth
            <div class="header-extras">
                <ul>
                    <li>
                        <div class="p-dropdown">
                            <a href="javascript:void(0)">
                                <strong>Hi</strong>, {{ auth()->user()->name }}
                            </a>
                            <ul class="p-dropdown-content">
                                <li><a href="javascript:void(0)" class="text-muted"><small>Point: {{
                                            auth()->user()->point }}</small></a></li>
                                <li><a href="{{ route('client.account.index') }}">Account</a></li>

                                <li><a href="{{ route('client.order.index') }}">History Order</a></li>

                                <li><a href="{{ route('client.reedem-point.index') }}">Reedem Point</a></li>

                                <li>
                                    <a href="javascript:void(0)">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fas fa-sign-out-alt text-white me-2"></i>Logout</button>
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            @endauth

            <!--Navigation Resposnive Trigger-->
            <div id="mainMenu-trigger">
                <a class="lines-button x"><span class="lines"></span></a>
            </div>

            <!--Navigation-->
            <div id="mainMenu">
                <div class="container">
                    <nav>
                        <ul>
                            <li>
                                <a
                                    href="{{ auth()->check() && !empty($cartTotal) ? route('client.cart.index') : 'javascript:void(0)' }}">
                                    <button class="btn btn-light position-relative">
                                        <i class="fa fa-shopping-bag"></i>
                                        @if (auth()->check() && !empty($cartTotal) && $cartTotal->detail->count() > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $cartTotal->detail->count() }}
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                        @endif
                                    </button>
                                </a>
                            </li>

                            @if (!auth()->check())
                            <li>
                                <a href="{{ route('register.index') }}" class="p-5">
                                    <button type="button" class="btn btn-outline">Register</button>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login.index') }}" class="p-5">
                                    <button type="button" class="btn btn-primary">Login</button>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>