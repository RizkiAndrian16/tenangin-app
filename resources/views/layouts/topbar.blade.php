@php
    $notificationCount = 0;

    if (auth()->user()->isMahasiswa()) {
        if (!auth()->user()->hasCompleteProfile()) {
            $notificationCount++;
        }

        if (auth()->user()->needsPasswordSetup()) {
            $notificationCount++;
        }
    }
@endphp

<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align d-flex flex-row align-items-center gap-2">
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon position-relative" href="#" id="notificationDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">

                    <i class="align-middle" data-feather="bell"></i>

                    @if ($notificationCount > 0)
                        <span class="topbar-notification-badge">{{ $notificationCount }}</span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-end topbar-notification-menu"
                    aria-labelledby="notificationDropdown">

                    <div class="topbar-notification-header">
                        <span class="fw-semibold">Notifikasi</span>

                        @if ($notificationCount > 0)
                            <span class="topbar-notification-count">
                                {{ $notificationCount }} baru
                            </span>
                        @endif
                    </div>

                    @if ($notificationCount > 0)

                        {{-- NOTIFIKASI: PROFIL BELUM LENGKAP --}}
                        @if (auth()->user()->isMahasiswa() && !auth()->user()->hasCompleteProfile())
                            <a href="{{ route('profile.edit') }}" class="topbar-notification-item">

                                <div class="topbar-notification-icon">
                                    <i data-feather="user"></i>
                                </div>

                                <div class="topbar-notification-content">
                                    <div class="topbar-notification-title">
                                        Lengkapi profilmu
                                    </div>

                                    <div class="topbar-notification-text">
                                        Lengkapi data profilmu agar kamu dapat menggunakan seluruh fitur Tenangin.
                                    </div>

                                    <div class="topbar-notification-action">
                                        Lengkapi Profil
                                        <i data-feather="arrow-right"></i>
                                    </div>
                                </div>
                            </a>
                        @endif

                        {{-- NOTIFIKASI: AKUN GOOGLE BELUM MEMILIKI PASSWORD --}}
                        @if (auth()->user()->needsPasswordSetup())
                            <a href="{{ route('profile.edit', ['action' => 'password']) }}"
                                class="topbar-notification-item">

                                <div class="topbar-notification-icon">
                                    <i data-feather="key"></i>
                                </div>

                                <div class="topbar-notification-content">
                                    <div class="topbar-notification-title">
                                        Atur password akunmu
                                    </div>

                                    <div class="topbar-notification-text">
                                        Biar aksesnya makin gampang, tambahkan password yuk! Nanti kamu jadi punya
                                        alternatif untuk login pakai email.
                                    </div>

                                    <div class="topbar-notification-action">
                                        Atur Password
                                        <i data-feather="arrow-right"></i>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @else
                        <div class="topbar-notification-empty">
                            <div class="topbar-notification-empty-icon">
                                <i data-feather="bell"></i>
                            </div>

                            <span>Tidak ada notifikasi baru</span>
                        </div>

                    @endif
                </div>
            </li>

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
                        {{ auth()->user()->needsPasswordSetup() ? 'Atur Password' : 'Ubah Password' }}
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
