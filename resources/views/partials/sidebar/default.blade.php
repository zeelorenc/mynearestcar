<ul class="sidebar-menu">
    <li class="{{ Request::route()->getName() == 'home' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-car-side"></i> <span>Rent a car</span>
        </a>
    </li>
</ul>
