<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Gestion Med</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    @auth
        @if(auth()->user()->role === 'admin')
            <div class="sidebar-heading">Administration</div>

            <li class="nav-item {{ request()->is('admin/services*') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/services">
                    <i class="fas fa-fw fa-stethoscope"></i>
                    <span>Services médicaux</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/reservations*') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/reservations">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Réservations</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                <a class="nav-link" href="/admin/users">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'medecin')
            <div class="sidebar-heading">Mon espace</div>

            <li class="nav-item {{ request()->is('medecin/services*') ? 'active' : '' }}">
                <a class="nav-link" href="/medecin/services">
                    <i class="fas fa-fw fa-stethoscope"></i>
                    <span>Mes services</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('medecin/reservations*') ? 'active' : '' }}">
                <a class="nav-link" href="/medecin/reservations">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Mes réservations</span>
                </a>
            </li>
        @endif

        @if(auth()->user()->role === 'patient')
            <div class="sidebar-heading">Mon espace</div>

            <li class="nav-item {{ request()->is('services*') ? 'active' : '' }}">
                <a class="nav-link" href="/services">
                    <i class="fas fa-fw fa-list-alt"></i>
                    <span>Services disponibles</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('mes-reservations*') ? 'active' : '' }}">
                <a class="nav-link" href="/mes-reservations">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Mes réservations</span>
                </a>
            </li>
        @endif
    @endauth

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
