<ul class="sidebar-menu">
    <li class="{{ Request::route()->getName() == 'home' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-car-side"></i> <span>Rent a Car</span>
        </a>
    </li>

    <li class="{{ Request::route()->getName() == 'carsearch' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('carsearch') }}">
            <i class="fas fa-search"></i> <span>Car Search</span>
        </a>
    </li>

    <li class="{{ Request::route()->getName() == 'contactus' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('contactus') }}">
            <i class="fas fa-address-card"></i> <span>Contact Us</span>
        </a>
    </li>
</ul>
