<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand custom-sidebar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets-admin/img/logo/LogoSistem.png') }}" alt="Logo" class="sidebar-logo">
            <span class="sidebar-brand-text">Tenangin.</span>
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-header fw-bold">MENU</li>
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-header fw-bold">USER</li>
            <li class="sidebar-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('profile.edit') }}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">Profile</span>
                </a>
            </li>
            <li
                class="sidebar-item {{ request()->routeIs('pss-assessments.*') || request()->routeIs('recommendations.index') || request()->routeIs('recommendations.final') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('pss-assessments.index') }}">
                    <i class="align-middle" data-feather="clipboard"></i>
                    <span class="align-middle">PSS-10</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('recommendations.history*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('recommendations.history') }}">
                    <i class="align-middle" data-feather="clock"></i>
                    <span class="align-middle">Riwayat Rekomendasi</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('#.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="message-circle"></i>
                    <span class="align-middle">Feedback</span>
                </a>
            </li>
            <li class="sidebar-header fw-bold">RELAKSASI</li>
            <li class="sidebar-item {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('activities.index') }}">
                    <i class="align-middle" data-feather="grid"></i>
                    <span class="align-middle">Katalog Aktivitas</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('rule-based-rules.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('rule-based-rules.index') }}">
                    <i class="align-middle" data-feather="git-branch"></i>
                    <span class="align-middle">Aturan Rekomendasi</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
