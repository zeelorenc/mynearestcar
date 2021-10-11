
<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ $currentUser->role === 'admin' ? route('admin.index') : route('home') }}">{{ env('APP_NAME') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ $currentUser->role === 'admin' ? route('admin.index') : route('home') }}">MNC</a>
    </div>

    <!-- This is a sidebar navigation -->
    @if ($currentUser->role === 'client')
        @include ('partials.sidebar.default')
    @endif

    @if ($currentUser->role === 'admin')
        @include ('partials.sidebar.admin')
    @endif

</aside>
