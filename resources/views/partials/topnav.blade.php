<form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>


<ul class="navbar-nav navbar-right">

    <!-- Dropdown notification list-->
    <!--
    <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
            <i class="far fa-bell"></i>
        </a>

        <div class="dropdown-menu dropdown-list dropdown-menu-right">
            <div class="dropdown-header">Notifications</div>

            <div class="dropdown-list-content dropdown-list-icons">
                <div class="dropdown-item dropdown-item-unread">
                    <div class="dropdown-item-icon bg-primary text-white">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="dropdown-item-desc">
                        This is a message title
                        <div>Date / Time</div>
                        <div>
                            <a href="#" class="btn btn-success btn-sm">Button</a>
                            <a href="#" class="btn btn-danger btn-sm">Button</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown-item dropdown-item-unread">
                    <div class="dropdown-item-icon bg-info text-white">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <div class="dropdown-item-desc">
                        This is a unread message title
                        <div class="time">Date / Time</div>
                    </div>
                </div>
            </div>

            <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </li>
    -->

    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <!--<img alt="image" src="{{ asset('assets/img/avatar/avatar-4.png') }}" class="rounded-circle mr-1">-->
            <div class="d-sm-none d-lg-inline-block">Hi, {{ $currentUser->name }}</div>
        </a>

        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{ route($currentUser->role === 'admin' ? 'admin.profile.index' : 'profile.index', $currentUser->id) }}" class="dropdown-item has-icon">
                <i class="fas fa-user"></i> {{ __('My Profile') }}
            </a>

            <div class="dropdown-divider"></div>

            <a href="{{ route('order.history') }}" class="dropdown-item has-icon">
                <i class="fas fa-history"></i> {{ __('Rental History') }}
            </a>

            <div class="dropdown-divider"></div>

            @if (auth()->user()->orders()->where('status', 'paid')->first())
            <a href="{{ route('order.current') }}" class="dropdown-item has-icon">
                <i class="fas fa-calendar-check"></i> {{ __('My Current Booking') }}
            </a>

            <div class="dropdown-divider"></div>
            @endif

            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
</ul>
