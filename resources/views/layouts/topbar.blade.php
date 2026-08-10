@php
    $notificationCount = 0;
    $pendingFeedbackData = null;

    if (auth()->user()->isMahasiswa()) {
        if (!auth()->user()->hasCompleteProfile()) {
            $notificationCount++;
        }

        if (auth()->user()->needsPasswordSetup()) {
            $notificationCount++;
        }

        $pendingFeedbackStatus = auth()->user()->getTodayPendingRecommendationStatus();
        if ($pendingFeedbackStatus['has_pending']) {
            $notificationCount++;
            $pendingFeedbackData = $pendingFeedbackStatus;
        }
    }
@endphp

<nav class="navbar navbar-expand-sm navbar-light navbar-bg position-relative d-flex align-items-center">

    <!-- MOBILE HEADER WRAPPER (ON DESKTOP IT DISAPPEARS STRUCTURALLY USING display: contents) -->
    <div class="topbar-mobile-header">
        <!-- KIRI: TOMBOL HAMBURGER -->
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>

        <!-- TENGAH: LOGO DAN NAMA SISTEM (HANYA MUNCUL DI HP) -->
        <div class="topbar-mobile-logo d-flex d-sm-none align-items-center">
            <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="Tenangin" width="30" height="30">
            <span class="fw-bold ms-2 text-dark logo-text">Tenangin</span>
        </div>

        <!-- KANAN: TOMBOL 3 TITIK (HANYA MUNCUL DI HP) -->
        <button class="navbar-toggler d-sm-none ms-auto border-0 bg-transparent p-0 position-relative topbar-mobile-btn"
            type="button" data-bs-toggle="collapse" data-bs-target="#topbarMobileMenu" aria-controls="topbarMobileMenu"
            aria-expanded="false" aria-label="Toggle Menu">
            <i class="align-middle" data-feather="more-horizontal"></i>

            {{-- Titik Merah Notifikasi di Tombol 3 Titik --}}
            @if ($notificationCount > 0)
                <span class="mobile-notification-dot"></span>
            @endif
        </button>
    </div>

    <!-- BUNGKUSAN MENU TOPBAR (DROPDOWN FULL WIDTH DI HP) -->
    <div class="navbar-collapse collapse" id="topbarMobileMenu">
        <div class="topbar-mobile-content">
            <ul class="navbar-nav navbar-align d-flex flex-row align-items-center ms-auto">

                <!-- MENU 1: NOTIFIKASI -->
                @if (auth()->user()->isMahasiswa())
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon position-relative" href="#" id="notificationDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
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
                                    <span class="topbar-notification-count">{{ $notificationCount }} baru</span>
                                @endif
                            </div>
                            @if ($notificationCount > 0)
                                @if (auth()->user()->isMahasiswa() && !auth()->user()->hasCompleteProfile())
                                    <a href="{{ route('profile.edit') }}" class="topbar-notification-item">
                                        <div class="topbar-notification-icon"><i data-feather="user"></i></div>
                                        <div class="topbar-notification-content">
                                            <div class="topbar-notification-title">Lengkapi profilmu</div>
                                            <div class="topbar-notification-text">Lengkapi data profilmu agar kamu dapat
                                                menggunakan seluruh fitur Tenangin.</div>
                                            <div class="topbar-notification-action">Lengkapi Profil <i
                                                    data-feather="arrow-right"></i></div>
                                        </div>
                                    </a>
                                @endif
                                @if (auth()->user()->needsPasswordSetup())
                                    <a href="{{ route('profile.edit', ['action' => 'password']) }}"
                                        class="topbar-notification-item">
                                        <div class="topbar-notification-icon"><i data-feather="key"></i></div>
                                        <div class="topbar-notification-content">
                                            <div class="topbar-notification-title">Atur password akunmu</div>
                                            <div class="topbar-notification-text">Biar aksesnya makin gampang, tambahkan
                                                password yuk! Nanti kamu jadi punya alternatif untuk login pakai email.
                                            </div>
                                            <div class="topbar-notification-action">Atur Password <i
                                                    data-feather="arrow-right"></i></div>
                                        </div>
                                    </a>
                                @endif
                                @if ($pendingFeedbackData)
                                    <a href="{{ $pendingFeedbackData['redirect_url'] }}"
                                        class="topbar-notification-item">
                                        <div class="topbar-notification-icon"><i data-feather="heart"></i></div>
                                        <div class="topbar-notification-content">
                                            <div class="topbar-notification-title">{{ $pendingFeedbackData['title'] }}</div>
                                            <div class="topbar-notification-text">{{ $pendingFeedbackData['text'] }}</div>
                                            <div class="topbar-notification-action">
                                                {{ $pendingFeedbackData['action_label'] }} <i data-feather="arrow-right"></i>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @else
                                <div class="topbar-notification-empty">
                                    <div class="topbar-notification-empty-icon"><i data-feather="bell"></i></div>
                                    <span>Tidak ada notifikasi baru</span>
                                </div>
                            @endif
                        </div>
                    </li>
                @endif

                <!-- MENU 2: DARK MODE -->
                <li class="nav-item">
                    <a class="nav-link nav-icon" href="#" id="darkModeToggle" role="button" title="Ubah Tema">
                        <i class="align-middle" data-feather="moon"></i>
                    </a>
                </li>

                <!-- MENU 3: PROFIL -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle topbar-profile-toggle d-inline-flex align-items-center"
                        href="#" data-bs-toggle="dropdown" aria-expanded="false">

                        @if (auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                class="topbar-avatar me-1" alt="{{ auth()->user()->name }}" />
                        @else
                            <div class="topbar-avatar-initial me-1">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif

                        <span class="text-dark ms-1 profile-name-desktop">
                            {{ auth()->user()->name }}
                        </span>

                        <span class="text-dark ms-1 profile-name-mobile">
                            {{ Str::words(auth()->user()->name, 2, '...') }}
                        </span>

                        <i class="topbar-profile-chevron" data-feather="chevron-down"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="align-middle me-1" data-feather="user"></i> Edit Profil
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
    </div>
</nav>
