
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}">{{ env('APP_NAME') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('home') }}">MNC</a>
    </div>

    <!-- This is a sidebar navigation -->
    @include ('partials.sidebar.default')

    @if ($currentUser->role === 'admin')
        @include ('partials.sidebar.admin')
    @endif

</aside>
