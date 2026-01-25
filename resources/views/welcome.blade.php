@extends('layouts.main')

@section('title', 'Bright Future Hub | Your Gateway to Global Success')

@section('styles')
    <style>
        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 33, 71, 0.7), rgba(0, 33, 71, 0.6)),
                url('{{ asset("images/hero_campus_background_1768811614804.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 90vh;
            color: white;
            position: relative;
            display: flex;
            align-items: center;
            padding-top: 60px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: #ffffff !important;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        /* Glass Search Box */
        .search-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        .search-input {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            padding: 15px 20px;
            border-radius: 10px;
            font-size: 1rem;
            height: auto;
        }

        .search-input:focus {
            background: #fff;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }

        /* Partner Logos */
        .partners-section {
            background: #fff;
            padding: 40px 0;
            border-bottom: 1px solid #eee;
        }

        .partner-logo-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }

        .partners-img {
            max-width: 100%;
            height: auto;
            transition: transform 0.3s;
        }

        .partners-img:hover {
            opacity: 1;
            filter: grayscale(0%);
        }

        /* Category Cards */
        .category-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: var(--gradient-primary);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .category-card:hover::before {
            height: 100%;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .category-card:hover h4,
        .category-card:hover p,
        .category-card:hover i {
            color: white !important;
        }

        .cat-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            transition: all 0.3s;
        }

        /* Premium Opportunity Cards */
        .premium-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.08);
            border-color: var(--accent-color);
        }

        .card-header-img {
            height: 140px;
            background: var(--gradient-primary);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.1);
            font-size: 4rem;
        }

        .org-logo-absolute {
            position: absolute;
            bottom: -25px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 12px;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-body-content {
            padding: 35px 20px 20px;
            flex-grow: 1;
        }

        .tag-pill {
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tag-internship {
            background: #e3f2fd;
            color: #0d47a1;
        }

        .tag-scholarship {
            background: #fff8e1;
            color: #ff6f00;
        }

        .tag-job {
            background: #e8f5e9;
            color: #1b5e20;
        }

        /* Testimonials */
        .testimonial-card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--accent-color);
        }

        .quote-icon {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-4 shadow-sm">
                        <i class="fas fa-star me-2"></i>#1 Education Portal in Pakistan
                    </div>
                    <h1 class="hero-title">
                        Unlock Your Global <br>
                        <span style="color: var(--accent-color);">Academic Future</span>
                    </h1>
                    <p class="hero-subtitle">
                        Access 1000+ fully-funded scholarships, premium internships, and university admissions.
                        Your journey to success starts with a single search.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-accent btn-lg shadow-lg">
                            Get Started Free
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-light btn-lg">
                            How It Works
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                    <div class="search-container">
                        <h4 class="fw-bold mb-4"><i class="fas fa-search me-2 text-warning"></i>Find Opportunities</h4>
                        <form action="{{ route('student.opportunities.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="small opacity-75 mb-1">What are you looking for?</label>
                                <input type="text" name="search" class="form-control search-input"
                                    placeholder="e.g. Software Engineering, MBA...">
                            </div>
                            <div class="mb-4">
                                <label class="small opacity-75 mb-1">Category</label>
                                <select name="type" class="form-select search-input">
                                    <option value="">All Categories</option>
                                    <option value="scholarship">Scholarships</option>
                                    <option value="internship">Internships</option>
                                    <option value="admission">University Admissions</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow">
                                Search Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>



    <!-- Categories Section -->
    <section class="py-5 bg-light" style="padding-top: 100px !important; padding-bottom: 100px !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="display-5 fw-bold mb-3">Explore Categories</h2>
                <div class="mx-auto bg-warning" style="width: 80px; height: 4px; border-radius: 2px;"></div>
            </div>

            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <a href="{{ route('student.opportunities.index', ['type' => 'scholarship']) }}"
                        class="text-decoration-none text-dark">
                        <div class="category-card">
                            <i class="fas fa-graduation-cap cat-icon"></i>
                            <h4 class="fw-bold mb-3">Scholarships</h4>
                            <p class="text-muted mb-0">Fully funded & partial scholarships for local and international
                                studies.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('student.opportunities.index', ['type' => 'internship']) }}"
                        class="text-decoration-none text-dark">
                        <div class="category-card">
                            <i class="fas fa-briefcase cat-icon"></i>
                            <h4 class="fw-bold mb-3">Internships</h4>
                            <p class="text-muted mb-0">Gain practical experience with top companies and startups.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('student.opportunities.index', ['type' => 'admission']) }}"
                        class="text-decoration-none text-dark">
                        <div class="category-card">
                            <i class="fas fa-university cat-icon"></i>
                            <h4 class="fw-bold mb-3">Admissions</h4>
                            <p class="text-muted mb-0">Secure your seat in HEC recognized universities.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Trusted Partners Section -->
    <section class="partners-section">
        <div class="container text-center">
            <p class="text-uppercase text-muted fw-bold small letter-spacing-2 mb-4">Trusted by Top Institutes &
                Organizations</p>
            <div class="row justify-content-center align-items-center g-5">
                @forelse($partners as $partner)
                    <div class="col-6 col-md-4 col-lg-3">
                        <img src="{{ asset($partner->logo) }}" alt="{{ $partner->organization_name }}"
                            class="img-fluid partners-img" style="max-height: 250px; width: auto; object-fit: contain;"
                            title="{{ $partner->organization_name }}">
                    </div>
                @empty
                    <div class="col-12">
                        <img src="{{ asset('images/university_logos_placeholder_1768811641915.png') }}"
                            alt="Partner Universities" class="img-fluid" style="max-height: 250px;">
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Latest Opportunities Section -->
    <section class="section-padding py-5">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-right">
                <div>
                    <h6 class="text-primary fw-bold text-uppercase mb-2">New Arrivals</h6>
                    <h2 class="fw-bold display-6">Latest Opportunities</h2>
                </div>
                <a href="{{ route('student.opportunities.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                    View All Opportunities <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="row g-4">
                @forelse($latestOpportunities as $opp)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="premium-card">
                            <div class="card-header-img">
                                <i
                                    class="fas {{ $opp->type == 'scholarship' ? 'fa-graduation-cap' : ($opp->type == 'internship' ? 'fa-laptop-code' : 'fa-building') }}"></i>
                                <div class="org-logo-absolute">
                                    <span
                                        class="fw-bold text-primary fs-4">{{ substr($opp->organization->organization_name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="card-body-content">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="tag-pill tag-{{ $opp->type }}">{{ ucfirst($opp->type) }}</span>
                                    <small class="text-muted"><i class="far fa-clock me-1"></i>
                                        {{ $opp->created_at->diffForHumans() }}</small>
                                </div>
                                <h5 class="fw-bold mb-2">
                                    <a href="{{ route('opportunities.show', $opp->id) }}"
                                        class="text-dark text-decoration-none hover-primary">
                                        {{ $opp->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-3">{{ $opp->organization->organization_name }} •
                                    {{ $opp->location ?? 'Pakistan' }}
                                </p>
                                <hr class="opacity-10 my-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">{{ $opp->fees ? $opp->fees : 'Free' }}</span>
                                    <a href="{{ route('opportunities.show', $opp->id) }}"
                                        class="text-primary fw-bold small text-decoration-none">
                                        Apply Now <i class="fas fa-chevron-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-folder-open text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-muted">No active opportunities found.</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Student Testimonials Section -->
    <section class="py-5 bg-light position-relative">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h6 class="text-primary fw-bold text-uppercase mb-2">Success Stories</h6>
                <h2 class="display-5 fw-bold">What Our Students Say</h2>
            </div>

            <div class="row g-4">
                <!-- Testimonial 1 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card h-100">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <p class="mb-4 text-secondary">"Bright Future Hub helped me secure a fully funded scholarship at
                            LUMS. The process was seamless and the guidance was exceptional."</p>
                        <div class="d-flex align-items-center">
                            <!-- Use part of the generated avatar image or a placeholder icon if cropping isn't easy, but here I'll simulate avatars using FontAwesome if image is 1 block -->
                            <div class="rounded-circle bg-secondary overflow-hidden me-3"
                                style="width: 50px; height: 50px;">
                                <!-- Since we have one strip image, we'll try to use object-position to show one face, or just use a placeholder icon -->
                                <img src="{{ asset('images/student_avatars_1768811667593.png') }}" class="img-fluid"
                                    style="width: 150px; max-width: none; margin-left: 0;">
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Sarah Ahmed</h6>
                                <small class="text-muted">LUMS Scholar</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card h-100">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <p class="mb-4 text-secondary">"I found my dream internship through this platform. It connected me
                            with top tech companies in Lahore. Highly recommended!"</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary overflow-hidden me-3"
                                style="width: 50px; height: 50px;">
                                <img src="{{ asset('images/student_avatars_1768811667593.png') }}" class="img-fluid"
                                    style="width: 150px; max-width: none; margin-left: -50px;">
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Ali Khan</h6>
                                <small class="text-muted">Software Intern</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card h-100">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <p class="mb-4 text-secondary">"The platform is very user-friendly. I applied for multiple
                            admissions and got accepted into NUST. Thank you Bright Future Hub!"</p>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary overflow-hidden me-3"
                                style="width: 50px; height: 50px;">
                                <img src="{{ asset('images/student_avatars_1768811667593.png') }}" class="img-fluid"
                                    style="width: 150px; max-width: none; margin-left: -100px;">
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Zainab Bibi</h6>
                                <small class="text-muted">NUST Student</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white position-relative overflow-hidden">
        <div class="container py-5 position-relative" style="z-index: 2;">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8" data-aos="zoom-in">
                    <h2 class="fw-bold display-5 mb-4">Start Your Journey Today</h2>
                    <p class="lead mb-5 opacity-75">Join thousands of students who are shaping their future with Bright
                        Future Hub.</p>
                    <a href="{{ route('register') }}"
                        class="btn btn-accent btn-lg px-5 shadow-lg fw-bold rounded-pill">Create Free Account</a>
                </div>
            </div>
        </div>
        <!-- Decorative Circle -->
        <div
            style="position: absolute; top: -100px; right: -100px; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%;">
        </div>
        <div
            style="position: absolute; bottom: -50px; left: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;">
        </div>
    </section>
@endsection