<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - MotoService Pro</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-navy: #1e3a8a;
            --dark-navy: #0f172a;
            --accent-blue: #3b82f6;
            --light-bg: #f8fafc;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            color: #334155;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
        }

        #sidebar .brand {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        #sidebar .nav-link {
            color: #94a3b8;
            font-weight: 500;
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
        }

        #sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }

        #sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        #sidebar .nav-link i {
            font-size: 1.2rem;
        }

        /* Main Content Wrapper */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 28px;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Cards & Components */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02), 0 1px 2px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 16px 20px;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }

        .btn-primary {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            font-weight: 500;
            border-radius: 8px;
            padding: 8px 16px;
        }

        .btn-primary:hover {
            background-color: #172554;
            border-color: #172554;
        }

        .btn-outline-primary {
            color: #1e3a8a;
            border-color: #1e3a8a;
            border-radius: 8px;
        }

        .btn-outline-primary:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }

        .table > :not(caption) > * > * {
            padding: 14px 16px;
            vertical-align: middle;
        }

        .table th {
            font-weight: 600;
            color: #475569;
            background-color: #f8fafc;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        .badge {
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 6px;
        }

        /* Stat Card */
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.show {
                margin-left: 0;
            }
            #main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Menu Kiri -->
    <aside id="sidebar">
        <div class="brand d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-tools fs-5"></i>
                </div>
                <div>
                    <h5 class="text-white mb-0 fw-bold" style="letter-spacing: -0.5px;">MotoService</h5>
                    <small class="text-secondary" style="font-size: 0.75rem;">Manajemen Bengkel Pro</small>
                </div>
            </div>
            <button class="btn btn-sm text-white d-lg-none" id="sidebarClose">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="py-3">
            <div class="px-4 py-2 text-uppercase text-secondary fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">
                Menu Utama
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard', 'home') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('pelanggan.index') }}" class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Data Pelanggan</span>
                </a>
                <a href="{{ route('kendaraan.index') }}" class="nav-link {{ request()->routeIs('kendaraan.*') ? 'active' : '' }}">
                    <i class="bi bi-bicycle"></i>
                    <span>Data Kendaraan</span>
                </a>
            </nav>

            <div class="px-4 pt-3 pb-2 text-uppercase text-secondary fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">
                Operasional Servis
            </div>
            <nav class="nav flex-column">
                <a href="{{ route('daftar-service.index') }}" class="nav-link {{ request()->routeIs('daftar-service.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Daftar Servis</span>
                </a>
                <a href="{{ route('data-service.index') }}" class="nav-link {{ request()->routeIs('data-service.*') ? 'active' : '' }}">
                    <i class="bi bi-wrench-adjustable"></i>
                    <span>Data Servis Mekanik</span>
                </a>
                <a href="{{ route('pembayaran.index') }}" class="nav-link {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Pembayaran Servis</span>
                </a>
            </nav>
        </div>

        <div class="position-absolute bottom-0 start-0 end-0 p-3 text-center border-top border-white-10 text-white-50 small">
            <span class="badge bg-dark border border-secondary text-light mb-1">XAMPP + MySQL</span><br>
            <small>© {{ date('Y') }} Project Akhir Service Motor</small>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div id="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">@yield('page_heading', 'Dashboard Administrasi')</h5>
                    <small class="text-muted">Aplikasi Manajemen Bengkel & Servis Kendaraan Bermotor</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="d-none d-md-flex align-items-center gap-2 bg-light px-3 py-2 rounded-3 border">
                    <i class="bi bi-calendar-event text-primary"></i>
                    <span class="small fw-medium" id="realtimeClock">{{ date('l, d F Y') }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                        AD
                    </div>
                    <div class="d-none d-sm-block text-start">
                        <span class="d-block fw-semibold text-dark small lh-1">Administrator</span>
                        <small class="text-success small" style="font-size: 0.75rem;">● Online</small>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Container -->
        <main class="container-fluid p-4 flex-grow-1">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <div class="fw-bold mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-x-circle-fill"></i> Terdapat kesalahan pada pengisian form:
                    </div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Content Slot -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-top py-3 px-4 text-center text-muted small mt-auto">
            &copy; {{ date('Y') }} Sistem Informasi Manajemen Service Motor. Dibuat dengan <strong>Laravel</strong> & <strong>Bootstrap 5</strong>.
        </footer>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Mobile Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', () => {
                sidebar.classList.remove('show');
            });
        }

        // Live Clock
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const el = document.getElementById('realtimeClock');
            if (el) {
                el.innerText = now.toLocaleDateString('id-ID', options);
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @stack('scripts')
</body>
</html>
