<aside class="dashboard-sidebar">
    <ul class="dashboard-sidebar__list">
        <li {{ Request::is( 'admin') ? 'class=active' : '' }}>
            <a href="{{ route('admin') }}" class="dashboard-sidebar__link">
                <span class="dashboard-sidebar__link-icon-container">
                    <svg viewbox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" class="dashboard-logo">
                        <path class="dashboard-logo__top" d="M299.2 47.7l-5.2-5.2c-1.7-1.7-4.6-1.7-6.3 0l-26.6 26.6c-0.8 0.8-1.8 1.2-2.9 1.3 -44.4 2.2-81.4 20.2-110.8 54.1 -28 32.1-43 70.5-45 115.5 5.7 2.5 1.9 0.8 7.6 3.3L282.6 70.6c0 0 0 0-0.1 0L299.2 54C301 52.2 301 49.4 299.2 47.7z"></path>
                        <path class="dashboard-logo__middle" d="M391.9 118.9c3.3 3.6 4.9 6.8 4.9 9.5 0 3.1-5.7 14.6-17 34.5 -11.3 19.9-18.5 31.1-21.4 33.5 -1.3 1.3-2.9 2-4.9 2 -0.8 0-4.9-3.3-12.2-9.8 -8.8-7.8-17.5-14-25.9-18.4 -12.9-6.5-26.3-9.8-40.1-9.8 -24 0-43.2 9-57.5 26.9 -13.2 16.6-19.8 37.2-19.8 61.7 0 0.7 0 1.4 0 2.1 0 1.2-0.4 2.4-1.3 3.3l-73.5 73.5c-2.3 2.3-6.1 1.5-7.3-1.5 -6.3-15.8-10.5-32.9-12.4-51.3 -0.1-1.3 0.3-2.7 1.3-3.6l3.2-3.2 0 0 261-261.5c1.7-1.7 4.6-1.7 6.3 0l5.2 5.2c1.7 1.7 1.7 4.5 0 6.3l-53.1 53.6c-2.3 2.4-1.4 6.3 1.8 7.4C353.8 87 374.7 100.3 391.9 118.9zM275.2 338.9c-24 0-43.2-9.1-57.5-27.4 -4.3-5.4-7.8-11.3-10.7-17.5 -0.8-1.7-0.4-3.7 0.9-5l19.5-19.5c1.7-1.7 1.7-4.6 0-6.3l-5.2-5.2c-1.7-1.7-4.6-1.7-6.3 0L98.8 375.1c-1.7 1.7-1.7 4.6 0 6.3l5.2 5.2c1.7 1.7 4.6 1.7 6.3 0l21.2-21.2c1.9-1.9 5-1.7 6.7 0.5 3.2 4.2 6.6 8.3 10.2 12.3 18 19.8 39.2 33.9 63.4 42.5 1.6 0.6 3.4 0.1 4.6-1.1l73.7-73.7c3-3 0.5-8.1-3.7-7.5C282.7 338.7 279 338.9 275.2 338.9z"></path>
                        <path class="dashboard-logo__bottom" d="M368.1 313.6l38.3-38.3c1.7-1.7 1.7-4.6 0-6.3l-5.2-5.2c-1.7-1.7-4.6-1.7-6.3 0L291.4 367.4l0 0 -52.9 52.9c-2.6 2.6-1.2 7 2.4 7.5 10 1.6 20.4 2.4 31.3 2.4 49.8 0 89.7-17.9 119.7-53.6 3.4-4.2 5.1-7.7 5.1-10.3 0-1.8-6-11.7-17.9-29.9 -4.6-6.9-8.4-12.6-11.6-17.2C366.4 317.5 366.6 315.1 368.1 313.6z"></path>
                     </svg>
                </span>
                <span class="dashboard-sidebar__link-name">LinkCutter</span>
            </a>
        </li>

        <li {{ Request::is( 'admin/products') ? 'class=active' : '' }}>
            <a href="{{ route('admin.products') }}" class="dashboard-sidebar__link dashboard-sidebar__link--active">
                <span class="dashboard-sidebar__link-icon-container">@icon('gift', 'dashboard-sidebar__link-icon')</span>
                <span class="dashboard-sidebar__link-name">Products</span>
            </a>
        </li>
        
        <li {{ Request::is( 'admin/plans') ? 'class=active' : '' }}>
            <a href="{{ route('admin.plans') }}" class="dashboard-sidebar__link dashboard-sidebar__link--active">
                <span class="dashboard-sidebar__link-icon-container">@icon('package', 'dashboard-sidebar__link-icon')</span>
                <span class="dashboard-sidebar__link-name">Plans</span>
            </a>
        </li>

        <li {{ Request::is( 'admin/features') ? 'class=active' : '' }}>
            <a href="{{ route('admin.features') }}" class="dashboard-sidebar__link">
                <span class="dashboard-sidebar__link-icon-container">@icon('zap', 'dashboard-sidebar__link-icon')</span>
                <span class="dashboard-sidebar__link-name">Features</span>
            </a>
        </li>
    </ul>

    <ul class="dashboard-sidebar__list">
        <li>
            <a href="{{ route('logout') }}" class="dashboard-sidebar__link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="dashboard-sidebar__link-icon-container">@icon('log-out', 'dashboard-sidebar__link-icon')</span>
                <span class="dashboard-sidebar__link-name">{{ __('Logout') }}</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>