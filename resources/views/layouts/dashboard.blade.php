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
    
    <!-- Modern Design System -->
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: var(--bg-body);
        }

        #wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        #sidebar-wrapper {
            background: #ffffff;
            border-right: 1px solid rgba(0,0,0,0.05);
            width: 280px;
            box-shadow: 10px 0 30px rgba(0,0,0,0.02);
            z-index: 1050; /* higher than navbar-dashboard */
            transition: all 0.3s ease;
            position: fixed;
            height: 100vh;
            left: -280px;
            overflow-y: auto;
        }

        #wrapper.toggled #sidebar-wrapper {
            left: 0;
        }

        .sidebar-heading {
            padding: 2rem 1.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.5px;
        }

        #page-content-wrapper {
            flex: 1;
            height: 100vh;
            overflow-y: auto;
            position: relative;
            background: transparent;
            width: 100%;
            transition: all 0.3s ease;
        }

        @media (min-width: 992px) {
            #sidebar-wrapper {
                position: relative;
                left: 0;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: -280px;
            }
        }

        .navbar-dashboard {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border-color);
            padding: 0 2rem;
            min-height: 80px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    </style>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="neo-sidebar">
            <div class="sidebar-heading">
                <i class="fas fa-graduation-cap me-2 text-warning"></i> Bright Future
            </div>
            <div class="mt-4">
                @if(Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ url('/dashboard') }}" class="sidebar-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                    <a href="{{ route('admin.organizations.pending') }}" class="sidebar-link {{ Request::is('admin/organizations/pending*') ? 'active' : '' }}">
                        <i class="fas fa-university"></i> Organization Requests
                    </a>
                @elseif(Auth::check() && Auth::user()->role == 'organization')
                    <a href="{{ url('/dashboard') }}" class="sidebar-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Overview
                    </a>
                    <a href="{{ route('organization.opportunities.create') }}" class="sidebar-link {{ Request::is('organization/opportunities/create*') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle"></i> New Post
                    </a>
                    <a href="{{ route('organization.opportunities.index') }}" class="sidebar-link {{ Request::is('organization/opportunities') ? 'active' : '' }}">
                        <i class="fas fa-list"></i> My Listings
                    </a>
                    <a href="{{ route('organization.applications.all') }}" class="sidebar-link {{ Request::is('organization/applications*') ? 'active' : '' }}">
                        <i class="fas fa-paper-plane"></i> Applications
                    </a>
                @else
                    <a href="{{ route('student.dashboard') }}" class="sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                    <a href="{{ route('student.opportunities.index') }}" class="sidebar-link {{ Request::is('student/opportunities*') ? 'active' : '' }}">
                        <i class="fas fa-briefcase"></i> Opportunities
                    </a>
                    <a href="{{ route('student.applications.index') }}" class="sidebar-link {{ Request::is('student/applications*') ? 'active' : '' }}">
                        <i class="fas fa-paper-plane"></i> Applications
                    </a>
                    <a href="{{ route('student.resume.index') }}" class="sidebar-link {{ Request::is('student/resume*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i> CV Builder
                    </a>
                    <a href="{{ route('student.career.roadmap') }}" class="sidebar-link {{ Request::is('student/career*') ? 'active' : '' }}">
                        <i class="fas fa-magic"></i> AI Roadmap
                    </a>
                    <a href="{{ route('student.profile.edit') }}" class="sidebar-link {{ Request::is('student/profile/edit') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i> Profile
                    </a>
                    <a href="/" class="sidebar-link">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                @endif
                <div class="border-top my-4 mx-4 opacity-10"></div>

                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="sidebar-link text-danger border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-dashboard d-flex justify-content-between align-items-center">
                <button class="btn bg-white border shadow-sm rounded-3 d-flex align-items-center justify-content-center" id="menu-toggle" style="width: 45px; height: 45px;">
                    <i class="fas fa-bars text-primary fa-lg"></i>
                </button>
                <div class="d-flex align-items-center gap-3">

                    
                    @auth
                    @if(Auth::user()->role == 'student')
                    <!-- Notifications Dropdown -->
                    <div class="dropdown me-3 dropdown-notifications">
                        <a href="#" class="text-secondary position-relative dropdown-toggle" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" id="notification-count" style="font-size: 0.6rem;">
                                0
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationsDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <li><h6 class="dropdown-header fw-bold border-bottom pb-2">Notifications</h6></li>
                            <div id="notification-list">
                                @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                    <li>
                                        <a class="dropdown-item py-2 border-bottom mark-as-read" href="{{ $notification->data['url'] ?? '#' }}" data-id="{{ $notification->id }}">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 text-primary fw-bold" style="font-size: 0.9rem;">{{ Str::limit($notification->data['title'] ?? 'New Notification', 30) }}</h6>
                                                <small class="text-muted" style="font-size: 0.75rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1 text-secondary text-wrap" style="font-size: 0.85rem; white-space: normal;">{{ $notification->data['message'] ?? '' }}</p>
                                        </a>
                                    </li>
                                @empty
                                    <li class="p-3 text-center text-muted" id="no-notifications">
                                        <small>No new notifications</small>
                                    </li>
                                @endforelse
                            </div>
                            <li><a class="dropdown-item text-center text-primary fw-bold pt-2 border-top" href="#" id="mark-all-read">Mark all as read</a></li>
                        </ul>
                    </div>
                    @endif
                    @endauth

                    <span class="text-secondary fw-bold">{{ Auth::user()->name ?? 'Guest' }}</span>
                    @if(Auth::check() && Auth::user()->isStudent() && Auth::user()->studentProfile && Auth::user()->studentProfile->profile_image)
                        <img src="{{ asset('storage/' . Auth::user()->studentProfile->profile_image) }}" alt="Profile" 
                             class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #eee;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold"
                            style="width: 40px; height: 40px; border: 1px solid #eee;">
                            {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </div>
                    @endif
                </div>
            </nav>

            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };

        // Initialize Bootstrap Tooltips
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });

        @auth
        $(document).ready(function() {
            let userId = {{ Auth::id() }};
            let unreadCount = {{ Auth::user()->unreadNotifications->count() }};
            
            function updateBadge() {
                let badge = $('#notification-count');
                badge.text(unreadCount);
                if (unreadCount > 0) {
                    badge.removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }
            
            updateBadge();

            // Listen to Pusher events via Laravel Echo
            setTimeout(() => {
                if(window.Echo) {
                    window.Echo.private('App.Models.User.' + userId)
                        .notification((notification) => {
                            unreadCount++;
                            updateBadge();
                            
                            // Remove "No notifications" message if it exists
                            $('#no-notifications').remove();
                            
                            // Create new notification HTML
                            let newNotification = `
                                <li>
                                    <a class="dropdown-item py-2 border-bottom mark-as-read bg-light" href="${notification.url || '#'}" data-id="${notification.id}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 text-primary fw-bold" style="font-size: 0.9rem;">${notification.title.substring(0, 30)}</h6>
                                            <small class="text-success fw-bold" style="font-size: 0.75rem;">Just now</small>
                                        </div>
                                        <p class="mb-1 text-secondary text-wrap" style="font-size: 0.85rem; white-space: normal;">${notification.message}</p>
                                    </a>
                                </li>
                            `;
                            
                            // Prepend to list
                            $('#notification-list').prepend(newNotification);
                            
                            // Keep max 5 items
                            if($('#notification-list li').length > 5) {
                                $('#notification-list li:last').remove();
                            }
                        });
                }
            }, 1000);

            // Mark single notification as read
            $(document).on('click', '.mark-as-read', function(e) {
                let id = $(this).data('id');
                let url = $(this).attr('href');
                let item = $(this);
                
                if(id && item.hasClass('bg-light')) {
                    e.preventDefault();
                    
                    $.ajax({
                        url: '{{ route('notifications.mark-as-read') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: function() {
                            item.removeClass('bg-light');
                            unreadCount--;
                            updateBadge();
                            if(url !== '#') window.location.href = url;
                        }
                    });
                }
            });

            // Mark all as read
            $('#mark-all-read').click(function(e) {
                e.preventDefault();
                
                if(unreadCount > 0) {
                    $.ajax({
                        url: '{{ route('notifications.mark-all-read') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            $('.mark-as-read').removeClass('bg-light');
                            unreadCount = 0;
                            updateBadge();
                        }
                    });
                }
            });
        });
        @endauth
    </script>
    @stack('scripts')
    @yield('scripts')
    @include('partials.chat_widget')
</body>

</html>