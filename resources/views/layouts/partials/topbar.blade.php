<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Mobile) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <span class="navbar-brand font-weight-bold text-primary d-none d-md-inline">
        Système de Réservation Médicale
    </span>

    <!-- Right Nav -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Info -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ auth()->user()->name ?? 'Utilisateur' }}
                    <span class="badge badge-secondary ml-1">{{ auth()->user()->role ?? '' }}</span>
                </span>
                <i class="fas fa-user-circle fa-fw fa-lg text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-item text-center text-muted small">
                    {{ auth()->user()->email ?? '' }}
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Déconnexion
                </a>
            </div>
        </li>
    </ul>

</nav>
