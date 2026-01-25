<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - Bright Future Hub')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            /* Premium Academic Palette */
            --primary-color: #002147;
            --primary-light: #003366;
            --accent-color: #FFD700;
            --sidebar-bg: #fff;
            --bg-light: #f3f6f9;
            --active-bg: #e3f2fd;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: #333;
        }

        #wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid #eee;
            flex-shrink: 0;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.03);
            z-index: 1000;
        }

        .sidebar-heading {
            padding: 1.5rem;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            border-bottom: 1px solid #eee;
            background: linear-gradient(to right, #ffffff, #f8f9fa);
            font-family: 'Playfair Display', serif;
        }

        .list-group-item {
            border: none;
            padding: 1rem 1.5rem;
            font-size: 0.95rem;
            color: #555;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .list-group-item:hover {
            color: var(--primary-color);
            background-color: #f8f9fa;
            padding-left: 1.8rem;
        }

        .list-group-item.active {
            color: var(--primary-color);
            background-color: var(--active-bg);
            border-left: 4px solid var(--accent-color);
            font-weight: 600;
        }

        #page-content-wrapper {
            flex: 1;
            overflow-y: auto;
            width: 100%;
        }

        .navbar-dashboard {
            background: #fff;
            border-bottom: 1px solid #eee;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .glass-card {
            background: #fff;
            border: 1px solid #eee;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">
                <i class="fas fa-graduation-cap me-2 text-warning"></i> Bright Future
            </div>
            <div class="list-group list-group-flush mt-3">
                <a href="{{ url('/') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-arrow-left me-2"></i> Back to Home
                </a>
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ url('/dashboard') }}"
                        class="list-group-item list-group-item-action {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="list-group-item list-group-item-action {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i> Manage Users
                    </a>
                    <a href="{{ route('admin.opportunities.pending') }}"
                        class="list-group-item list-group-item-action {{ Request::is('admin/opportunities/pending*') ? 'active' : '' }}">
                        <i class="fas fa-list-check me-2"></i> Approvals
                    </a>
                @elseif(Auth::check() && Auth::user()->role == 'organization')
                    <a href="{{ url('/dashboard') }}"
                        class="list-group-item list-group-item-action {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line me-2"></i> Overview
                    </a>
                    <a href="{{ route('organization.opportunities.create') }}"
                        class="list-group-item list-group-item-action {{ Request::is('organization/opportunities/create*') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle me-2"></i> Post Opportunity
                    </a>
                    <a href="{{ route('organization.opportunities.index') }}"
                        class="list-group-item list-group-item-action {{ Request::is('organization/opportunities') ? 'active' : '' }}">
                        <i class="fas fa-briefcase me-2"></i> My Listings
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}"
                        class="list-group-item list-group-item-action {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('student.opportunities.index') }}"
                        class="list-group-item list-group-item-action {{ Request::is('student/opportunities') ? 'active' : '' }}">
                        <i class="fas fa-search me-2"></i> Find Opportunities
                    </a>
                    <a href="{{ route('student.profile.edit') }}"
                        class="list-group-item list-group-item-action {{ Request::is('student/profile/edit') ? 'active' : '' }}">
                        <i class="fas fa-user me-2"></i> My Profile
                    </a>
                    <a href="{{ route('student.applications.index') }}"
                        class="list-group-item list-group-item-action {{ Request::is('student/applications') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-2"></i> My Applications
                    </a>
                @endif


                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="list-group-item list-group-item-action text-danger mt-5">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-dashboard d-flex justify-content-between align-items-center">
                <button class="btn btn-light" id="menu-toggle"><i class="fas fa-bars"></i></button>
                <div class="d-flex align-items-center gap-3">
                    @if(Auth::check() && Auth::user()->role === 'admin' && session('login_time'))
                        <div class="text-secondary me-2 fw-medium">
                            <i class="fas fa-clock me-1 text-primary"></i> <span id="session-timer">00:00</span>
                        </div>
                    @endif
                    <span class="text-secondary fw-bold">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold"
                        style="width: 40px; height: 40px; border: 1px solid #eee;">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                </div>
            </nav>

            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        @if(Auth::check() && Auth::user()->role === 'admin' && session('login_time'))
            const loginTime = new Date("{{ session('login_time') }}").getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const diff = now - loginTime;

                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                const formattedTime =
                    (hours > 0 ? hours.toString().padStart(2, '0') + ':' : '') +
                    minutes.toString().padStart(2, '0') + ':' +
                    seconds.toString().padStart(2, '0');

                const timerEl = document.getElementById('session-timer');
                if (timerEl) timerEl.textContent = formattedTime;
            }

            setInterval(updateTimer, 1000);
            updateTimer(); // Initial call
        @endif
    </script>
</body>

</html>