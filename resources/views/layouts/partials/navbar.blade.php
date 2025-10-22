<!-- Navbar -->
<nav class="main-header navbar navbar-expand" style="
    background: #7e3edb;
    color: #fff;
    box-shadow: 0 2px 8px rgba(108,46,183,0.2);
    padding: 0.6rem 1.2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
">
    <!-- Left Section -->
    <div style="display:flex; align-items:center;">
        <h1 style="margin:0; font-size:1.25rem; font-weight:600; color:#fff;">
            <i class="fas fa-home mr-2"></i> @yield('content-header', 'Dashboard')
        </h1>
    </div>

    <!-- Right Section -->
    <ul class="navbar-nav ml-auto" style="display:flex; align-items:center; gap:1.5rem; margin:0;">

        <!-- User -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" style="color:#fff;">
                <i class="fas fa-user-circle"></i> {{ auth()->user()->getFullname() }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('settings.index') }}" class="dropdown-item">
                    <i class="fas fa-cogs mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
