<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align d-flex flex-row align-items-center gap-2">
            <li class="nav-item">
                <a class="nav-link nav-icon" href="#" id="darkModeToggle" role="button" title="Ubah Tema">
                    <i class="align-middle" data-feather="moon"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    @if (auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="topbar-avatar me-1"
                            alt="{{ auth()->user()->name }}" />
                    @else
                        <div class="topbar-avatar-initial me-1">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="text-dark d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="align-middle me-1" data-feather="user"></i>
                        Profile
                    </a>

                    <a class="dropdown-item" href="{{ route('profile.edit', ['action' => 'password']) }}">
                        <i class="align-middle me-1" data-feather="key"></i>
                        Ubah Password
                    </a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
