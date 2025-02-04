<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('laundry*') ? '' : 'collapsed' }}" href="{{ route('laundry.index') }}">
                <i class="bi bi-basket"></i>
                <span>Data Laundry</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('users*') ? '' : 'collapsed' }}" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i>
                <span>Users Management</span>
            </a>
        </li>
    </ul>
</aside>