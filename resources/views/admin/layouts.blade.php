<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <style>
        :root {
            --sidebar-width: 317px;
            --navbar-height: 70px;
        }

        body {
            background-color: #FAFAFA;
            overflow-x: hidden;
        }

        /* Sidebar Desktop */
        #sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 1030;
            background: white;
            transition: all 0.3s ease-in-out;
        }

        /* Content Area */
        .content-wrapper {
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
        }

        .content {
            height: calc(100vh - var(--navbar-height));
            overflow-y: auto;
        }

        /* Responsive Mobile (Tampilan HP/Tablet) */
        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed;
                left: calc(-1 * var(--sidebar-width));
                /* Sembunyi ke kiri */
                height: 100vh;
            }

            #sidebar.show {
                left: 0;
                box-shadow: 10px 0 15px rgba(0, 0, 0, 0.05);
            }

            .content-wrapper {
                width: 100% !important;
                /* Content full screen di HP */
            }

            /* Overlay saat sidebar muncul di mobile */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.1);
                z-index: 1020;
            }

            #sidebar.show+.content-wrapper .sidebar-overlay {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="d-flex min-vh-100">
        @include('components.sidebar')

        <div class="content-wrapper flex-grow-1 d-flex flex-column">
            <div class="sidebar-overlay toggler-btn"></div>

            @include('components.navbar')

            <div class="content p-3 p-md-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        // Toggle sidebar saat tombol diklik
        $('.toggler-btn').on('click', function() {
            $('#sidebar').toggleClass('show');
        });

        // Opsional: Tutup sidebar otomatis jika layar di-resize ke desktop
        $(window).resize(function() {
            if ($(window).width() > 991.98) {
                $('#sidebar').removeClass('show');
            }
        });
    });
</script>
    @stack('scripts')
</body>

</html>
