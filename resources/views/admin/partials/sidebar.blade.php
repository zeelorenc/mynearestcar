
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.php">{{ env('APP_NAME') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.php">MNC</a>
    </div>

    <!-- This is a sidebar navigation -->
    <ul class="sidebar-menu">
        <li class="{{ Request::route()->getName() == 'admin.index' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fas fa-fire"></i> <span>{{ __('Dashboard') }}</span>
            </a>
        </li>


        <li class="menu-header"><i class="fas fa-car p-1 mr-2"></i> {{ __('Vehicle Management') }}</li>

        <li class="{{ Request::route()->getName() == 'admin.vehicle.list' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.vehicle.list') }}">
                <i class="fas fa-list"></i> <span>{{ __('Vehicle List') }}</span>
            </a>
        </li>
        <li class="{{ Request::route()->getName() == 'admin.vehicle.add' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.vehicle.add') }}">
                <i class="fas fa-plus"></i> <span>{{ __('Add Vehicle') }}</span>
            </a>
        </li>


        <li class="menu-header"><i class="fas fa-parking p-1 mr-2"></i> {{ __('Parking Management') }}</li>

        <li class="{{ Request::route()->getName() == 'admin.parking.list' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.parking.list') }}">
                <i class="fas fa-list"></i> <span>{{ __('Parking List') }}</span>
            </a>
        </li>
        <li class="{{ Request::route()->getName() == 'admin.parking.add' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.parking.add') }}">
                <i class="fas fa-plus"></i> <span>{{ __('Add Park') }}</span>
            </a>
        </li>


        <li class="menu-header"><i class="fas fa-receipt p-1 mr-2"></i> {{ __('Order Management') }}</li>

        <li class="{{ Request::route()->getName() == 'admin.order.search' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.order.search') }}">
                <i class="fas fa-search"></i> <span>{{ __('Search Order') }}</span>
            </a>
        </li>


        <li class="menu-header"><i class="fas fa-users p-1 mr-2"></i> {{ __('User Management') }}</li>

        <li class="{{ Request::route()->getName() == 'admin.user.search' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('admin.user.search') }}">
                <i class="fas fa-search"></i> <span>{{ __('Search User') }}</span>
            </a>
        </li>

    </ul>

</aside>