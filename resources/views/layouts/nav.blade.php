<nav class="navbar navbar-default navbar-static-top">
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
            <a class="navbar-brand" href="@guest {{url('/')}} @else {{url('/home')}}  @endguest">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span><span id="main_title">{{ config('app.name', 'Laravel') }}</span>
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
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('profile', Auth::user()->alias) }}">My Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('friend-requests', Auth::user()->alias) }}">Friend Requests
                                    @if ($nbr = Auth::user()->getNumberOfFriendRequests())
                                        <span class="badge badge-success">{{ $nbr }}</span>
                                        <span class="sr-only">unread messages</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('friends', Auth::user()->alias) }}">My Friends</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
            @auth
                <div class="col-sm-3 col-md-3 pull-right">
                    <form class="navbar-form" role="search" action="{{ route('search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" id="search" name="search" data-action="{{ route('search-autocomplete') }}" autocomplete="off" required>
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>
