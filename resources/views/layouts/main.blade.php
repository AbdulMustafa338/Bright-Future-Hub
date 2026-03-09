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

    <style>
        :root {
            /* Premium Academic Palette */
            --primary-color: #002147;
            /* Oxford Blue */
            --primary-light: #003366;
            --accent-color: #FFD700;
            /* Gold */
            --accent-hover: #FDB931;
            --text-dark: #1a1a1a;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
            --bg-white: #ffffff;
            --border-color: #e9ecef;

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #002147 0%, #004e92 100%);
            --gradient-gold: linear-gradient(135deg, #FFD700 0%, #FDB931 100%);

            /* Spacing & Shadows */
            --section-padding: 80px 0;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --card-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.12);
            --border-radius: 12px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
        }

        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        a:hover {
            color: var(--accent-hover);
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px 30px;
            font-weight: 500;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 33, 71, 0.2);
        }

        .btn-accent {
            background: var(--accent-color);
            color: var(--primary-color);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9rem;
        }

        .btn-accent:hover {
            background: var(--accent-hover);
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            color: var(--accent-color);
        }

        .nav-link {
            font-weight: 500;
            color: var(--primary-color) !important;
            margin: 0 10px;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--accent-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 70px 0 30px;
            margin-top: 50px;
        }

        .footer h5 {
            color: var(--accent-color);
            margin-bottom: 25px;
            font-weight: 600;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            display: block;
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .footer-link:hover {
            color: var(--accent-color);
            padding-left: 5px;
        }

        .social-link {
            display: inline-flex;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .social-link:hover {
            background: var(--accent-color);
            color: var(--primary-color);
            transform: translateY(-3px);
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
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
                <div class="col-lg-4">
                    <h3 class="fw-bold mb-4 text-white" style="font-family: 'Playfair Display';"><i
                            class="fa-solid fa-graduation-cap text-warning me-2"></i>Bright Future Hub</h3>
                    <p class="opacity-75 mb-4">Empowering students and connecting them with world-class opportunities.
                        Your gateway to scholarships, internships, and admissions in trusted organizations.</p>
                    <div class="d-flex">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <a href="{{ url('/') }}" class="footer-link">Home</a>
                    <a href="#" class="footer-link">Search Opportunities</a>
                    <a href="#" class="footer-link">Universities</a>
                    <a href="#" class="footer-link">Scholarships</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Support</h5>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Terms of Service</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Contact Us</a>
                </div>
                <div class="col-lg-4 col-md-12">
                    <h5>Newsletter</h5>
                    <p class="opacity-75">Subscribe to get the latest scholarships and internship updates directly to
                        your inbox.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control border-0 p-3" placeholder="Enter your email"
                            aria-label="Email">
                        <button class="btn btn-accent px-4 fw-bold" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="my-5" style="opacity: 0.1;">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 opacity-50">&copy; {{ date('Y') }} Bright Future Hub. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 opacity-50">Designed for Education.</p>
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
    @yield('scripts')
    @include('partials.chat_widget')
</body>

</html>