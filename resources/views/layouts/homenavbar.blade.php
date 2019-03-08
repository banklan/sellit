<nav class="navbar home_navbar navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('choose_ad_type') }}"><i class="fa fa-cart-arrow-down"></i> Post New Ad</a></li>
                    <li><a href="{{ route('login') }}"><i class="fa fa-sign-in"></i>Sign In</a></li>
                @else
               
                    <li><a href="{{ route('choose_ad_type') }}"><i class="fa fa-cart-arrow-down"></i> Post New Ad</a></li>
                    <li><a href="{{ route('services') }}">Services Ad</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->f_name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('profile') }}"><span class="navbar_dropd"><i class="fa fa-user"></i></span>My Profile</a></li>
                            <li><a href="{{ route('my_ads') }}"><span class="navbar_dropd"><i class="fa fa-user"></i></span>My Ads & Events</a></li>
                            <li><a href="{{ route('my_flags') }}"><span class="navbar_dropd"><i class="fa fa-flag"></i></span>My flags</a></li>
                            <li><a href=""><span class="navbar_dropd"><i class="fa fa-gear"></i></span>Preferences</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <span class="navbar_dropd"><i class="fa fa-sign-in"></i></span>
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>