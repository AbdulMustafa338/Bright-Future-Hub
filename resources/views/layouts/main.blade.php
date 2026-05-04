<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bright Future Hub | Premium Academic Portal')</title>
    <meta name="description"
        content="Connect with top universities and organizations for internships, scholarships, and admission opportunities in Pakistan.">

    <!-- Fonts: Playfair Display (Headings) & Poppins (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Modern Design System -->
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: var(--bg-body);
            padding-top: 85px; /* Space for fixed navbar */
        }

        /* Fixed Navbar Modernization */
        .navbar {
            background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-bottom: 2px solid rgba(0, 33, 71, 0.1);
            transition: all 0.4s ease;
            min-height: 85px;
        }

        .navbar-collapse {
            background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);
            padding: 1rem;
            border-radius: 0 0 15px 15px;
            margin-top: 10px;
        }
        
        @media (min-width: 992px) {
            .navbar-collapse {
                background: transparent;
                padding: 0;
                margin-top: 0;
            }
        }

        .navbar-brand, .nav-link {
            color: #002147 !important; /* Premium Navy color for contrast */
            font-weight: 600 !important;
        }

        .nav-link:hover, .nav-link.active {
            color: #004a99 !important;
            background: rgba(0, 33, 71, 0.08) !important;
        }

        .navbar .btn-accent {
            background: #002147 !important;
            color: white !important;
            border: none;
            border-radius: 8px;
            padding: 8px 24px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .navbar .btn-accent:hover {
            background: #004a99 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 33, 71, 0.2);
        }



        /* Notifications Premium Look */
        .dropdown-notifications .dropdown-menu {
            border-radius: 16px !important;
            padding: 1rem 0;
            border: 1px solid rgba(0,0,0,0.05) !important;
            box-shadow: var(--shadow-lg) !important;
        }

        /* Global Page Transitions */
        [data-aos] {
            pointer-events: none;
        }
        .aos-animate {
            pointer-events: auto;
        }

        /* Footer Premium Modernization */
        .footer {
            background: #001a35; /* Even deeper navy */
            position: relative;
            z-index: 10;
            padding-top: 5rem;
            padding-bottom: 2rem;
            color: #fff;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.3), transparent);
        }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #fff !important;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-logo i {
            color: var(--accent-color);
            filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.3));
        }

        .footer h3, .footer h5 {
            color: white !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .footer h5::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.65) !important;
            padding: 8px 0;
            display: block;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
        }

        .footer-link:hover {
            color: var(--accent-color) !important;
            transform: translateX(8px);
        }

        .social-link {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff !important;
            margin-right: 12px;
            transition: all 0.4s;
            text-decoration: none !important;
        }

        .social-link:hover {
            background: var(--accent-color);
            color: #002147 !important;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 215, 0, 0.2);
            border-color: var(--accent-color);
        }

        .newsletter-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
        }

        .newsletter-input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-radius: 12px 0 0 12px !important;
            padding: 12px 18px !important;
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        .newsletter-btn {
            background: var(--accent-color) !important;
            color: #002147 !important;
            border: none !important;
            border-radius: 0 12px 12px 0 !important;
            padding: 0 25px !important;
            font-weight: 700 !important;
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.2);
            padding: 1.5rem 0;
            margin-top: 5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
    @yield('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fa-solid fa-graduation-cap fa-lg"></i>
                Bright Future Hub
            </a>
            <button class="navbar-toggler border-0 shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <div class="bg-white rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-bars text-primary fa-lg"></i>
                </div>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                            href="{{ url('/') }}">Home</a></li>

                    @if(Route::has('about'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                    @endif

                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        
                        <!-- Notifications Dropdown -->
                        <li class="nav-item dropdown dropdown-notifications me-2">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="mainNotificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-10 start-80 translate-middle badge rounded-pill bg-danger d-none" id="main-notification-count" style="font-size: 0.55rem; padding: 0.25em 0.4em;">
                                    0
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="mainNotificationsDropdown" style="width: 320px; max-height: 400px; overflow-y: auto;">
                                <li><h6 class="dropdown-header fw-bold text-primary border-bottom pb-2">Notifications</h6></li>
                                <div id="main-notification-list">
                                    @forelse(Auth::user()->unreadNotifications->take(5) as $notification)
                                        <li>
                                            <a class="dropdown-item py-2 border-bottom mark-as-read" href="{{ $notification->data['url'] ?? '#' }}" data-id="{{ $notification->id }}">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.9rem;">{{ Str::limit($notification->data['title'] ?? 'New Notification', 30) }}</h6>
                                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-1 text-secondary text-wrap" style="font-size: 0.85rem; white-space: normal;">{{ $notification->data['message'] ?? '' }}</p>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="p-3 text-center text-muted" id="main-no-notifications">
                                            <small>No new notifications</small>
                                        </li>
                                    @endforelse
                                </div>
                                <li><a class="dropdown-item text-center text-primary fw-bold pt-2 border-top" href="#" id="main-mark-all-read">Mark all as read</a></li>
                            </ul>
                        </li>

                        <li class="nav-item ms-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-outline-danger btn-sm rounded-pill px-4">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item ms-3">
                            <a href="{{ route('register') }}" class="btn btn-accent shadow-sm">Get Started</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div style="padding-top: 0px;">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4" data-aos="fade-up">
                    <a href="{{ url('/') }}" class="footer-logo">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Bright Future Hub
                    </a>
                    <p class="opacity-75 mb-4" style="line-height: 1.8;">Empowering the next generation of global leaders by connecting students with world-class scholarships, internships, and admissions. Your future starts here.</p>
                    <div class="d-flex">
                        <a href="#" class="social-link" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link" title="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <h5>Quick Links</h5>
                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="footer-link">Home Navigation</a>
                        <a href="{{ route('student.opportunities.index') }}" class="footer-link">Explore Opportunities</a>
                        <a href="#how-it-works" class="footer-link">How It Works</a>
                        <a href="{{ route('register') }}" class="footer-link">Join As Student</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <h5>Support</h5>
                    <div class="mt-4">
                        <a href="#" class="footer-link">Resource Center</a>
                        <a href="#" class="footer-link">Privacy Policy</a>
                        <a href="#" class="footer-link">Terms of Service</a>
                        <a href="#" class="footer-link">Contact Support</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12" data-aos="fade-up" data-aos-delay="300">
                    <div class="newsletter-glass">
                        <h5>Stay Updated</h5>
                        <p class="opacity-75 small mb-4">Get the latest opportunities delivered to your inbox weekly.</p>
                        <div class="input-group">
                            <input type="email" class="form-control newsletter-input" placeholder="Your email address">
                            <button class="btn newsletter-btn" type="button">Join</button>
                        </div>
                        <p class="mt-3 x-small opacity-50 mb-0"><i class="fas fa-shield-alt me-1"></i> We respect your privacy.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container text-center">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 opacity-50 small">&copy; {{ date('Y') }} Bright Future Hub. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                        <p class="mb-0 opacity-50 small">Developed with <i class="fas fa-heart text-danger mx-1"></i> for better Education.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        @auth
        $(document).ready(function() {
            let userId = {{ Auth::id() }};
            let unreadCount = {{ Auth::user()->unreadNotifications->count() }};
            
            function updateBadge() {
                let badge = $('#main-notification-count');
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
                            
                            $('#main-no-notifications').remove();
                            
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
                            
                            $('#main-notification-list').prepend(newNotification);
                            
                            if($('#main-notification-list li').length > 5) {
                                $('#main-notification-list li:last').remove();
                            }
                        });
                }
            }, 1000);

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

            $('#main-mark-all-read').click(function(e) {
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