<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Med') — Admin</title>

    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                @include('layouts.partials.topbar')

                <!-- Page Content -->
                <div class="container-fluid">

                    {{-- Alertes flash --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>

            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- Scroll to Top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Déconnexion</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">Voulez-vous vraiment vous déconnecter ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    @stack('scripts')

</body>
</html>
