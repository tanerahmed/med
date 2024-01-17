<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Medical<span>Admin</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                {{-- Admin User --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="dashboard.html" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                {{-- Editor User --}}
                @elseif(Auth::check() && Auth::user()->role === 'editor')
                    <a href="dashboard.html" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">EDITOR Dashboard</span>
                    </a>
                {{-- Reviewer User --}}
                @elseif(Auth::check() && Auth::user()->role === 'reviewer')
                    <a href="dashboard.html" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">reviewer Dashboard</span>
                    </a>

                @endif 
            </li>

            @if (Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item nav-category">Users</li>
                <li class="nav-item">
                    <a href="{{ route('admin.user-list') }}" class="nav-link">
                        <i class="link-icon" data-feather="user"></i>
                        <span class="link-title">Users</span>
                    </a>
                </li>
            @endif


        </ul>
    </div>
</nav>
