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
                <a href="{{ route('canvaHome.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="layout"></i>
                    <span class="link-title">Web Site</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>


                {{-- Admin can see that button --}}
                @if (Auth::check() && Auth::user()->role === 'admin')
            <li class="nav-item nav-category">Users</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false"
                    aria-controls="users">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Users</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.users-list') }}" class="nav-link">List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users-create') }}" class="nav-link">Create</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif


            {{-- Admin and Editor can see that button --}}
            @if (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'editor'))
                {{-- Logs --}}
                <li class="nav-item nav-category">Logs</li>
                <li class="nav-item">
                    {{-- Admin User --}}
                    <a href="{{ route('logs.index') }}" class="nav-link">
                        <i class="link-icon" data-feather="rotate-ccw"></i>
                        <span class="link-title">Logs</span>
                    </a>
                </li>
            @endif


            {{-- Admin and Editor can see that button --}}
            @if (Auth::check() && (Auth::user()->role === 'author' || Auth::user()->role === 'admin'))
                <li class="nav-item nav-category">Articles</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#articles" role="button" aria-expanded="false"
                        aria-controls="articles">
                        <i class="link-icon" data-feather="folder"></i>
                        <span class="link-title">Articles</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="articles"> <!-- Различен ID за подменюто Articles -->
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('article.list') }}" class="nav-link">List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('article.create') }}" class="nav-link">Create</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif


            {{-- Admin can see that button --}}
            @if (Auth::check() && Auth::user()->role === 'reviewer')
                <li class="nav-item nav-category">Articles for review</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false"
                        aria-controls="users">
                        <i class="link-icon" data-feather="user"></i>
                        <span class="link-title">Review</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse" id="users">
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('review.list') }}" class="nav-link">My Review</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif


        </ul>
    </div>
</nav>


{{-- 
     --}}
