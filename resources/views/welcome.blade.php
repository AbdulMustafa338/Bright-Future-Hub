@extends('layouts.main')

@section('title', 'Bright Future Hub | Your Gateway to Global Success')

@section('styles')
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 33, 71, 0.8), rgba(0, 33, 71, 0.6)),
                url('{{ asset("images/hero_campus_background_1768811614804.png") }}');
            background-size: cover;
            background-position: center;
            min-height: 90vh;
            display: flex;
            align-items: center;
            color: white;
            padding-top: 20px;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .search-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .category-card-modern {
            background: #fff;
            padding: 3rem 2rem;
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,0.03);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: center;
        }

        .category-card-modern:hover {
            background: var(--primary);
            color: white !important;
            transform: translateY(-12px);
            box-shadow: var(--shadow-lg);
        }

        .category-card-modern:hover .cat-icon, 
        .category-card-modern:hover p, 
        .category-card-modern:hover h4 {
            color: white !important;
        }

        .cat-icon {
            font-size: 3.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            transition: 0.3s;
        }

        .premium-card-modern {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.4s;
            height: 100%;
        }

        .premium-card-modern:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px -12px rgba(0,0,0,0.1);
            border-color: var(--accent);
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
                        <a href="{{ route('register') }}" class="btn btn-lg px-5 shadow-lg fw-bold rounded-pill" style="background: linear-gradient(135deg, #FFD700 0%, #FDB931 100%); color: #002147; border: none; transition: transform 0.3s ease;">
                            Get Started Free
                        </a>
                        <a href="#how-it-works" class="btn btn-outline-light btn-lg rounded-pill px-4">
                            How It Works
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                    <div class="search-glass">
                        <h4 class="fw-bold mb-4 text-white"><i class="fas fa-search me-2 text-warning"></i>Find Opportunities</h4>
                        <form action="{{ route('student.opportunities.index') }}" method="GET">
                            <div class="mb-3">
                                <label class="small text-white opacity-75 mb-1">What are you looking for?</label>
                                <input type="text" name="search" class="form-control rounded-4 py-3 border-0"
                                    placeholder="e.g. Software Engineering, MBA...">
                            </div>
                            <div class="mb-4">
                                <label class="small text-white opacity-75 mb-1">Category</label>
                                <select name="type" class="form-select rounded-4 py-3 border-0">
                                    <option value="">All Categories</option>
                                    <option value="scholarship">Scholarships</option>
                                    <option value="internship">Internships</option>
                                    <option value="admission">University Admissions</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-premium-accent w-100 py-3 fw-bold border-0 shadow">
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
                        <div class="category-card-modern">
                            <i class="fas fa-graduation-cap cat-icon"></i>
                            <h4 class="fw-bold mb-3">Scholarships</h4>
                            <p class="text-muted mb-0">Fully funded & partial scholarships for local and international studies.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('student.opportunities.index', ['type' => 'internship']) }}"
                        class="text-decoration-none text-dark">
                        <div class="category-card-modern">
                            <i class="fas fa-briefcase cat-icon"></i>
                            <h4 class="fw-bold mb-3">Internships</h4>
                            <p class="text-muted mb-0">Gain practical experience with top companies and startups.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('student.opportunities.index', ['type' => 'admission']) }}"
                        class="text-decoration-none text-dark">
                        <div class="category-card-modern">
                            <i class="fas fa-university cat-icon"></i>
                            <h4 class="fw-bold mb-3">Admissions</h4>
                            <p class="text-muted mb-0">Secure your seat in HEC recognized universities.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works Section -->
    <section id="how-it-works" class="py-5" style="background: #fff; padding-top: 100px !important; padding-bottom: 100px !important;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h6 class="text-primary fw-bold text-uppercase mb-2">Simple Process</h6>
                <h2 class="display-5 fw-bold mb-3">How It Works</h2>
                <div class="mx-auto bg-warning" style="width: 80px; height: 4px; border-radius: 2px;"></div>
                <p class="text-muted mt-4 lead mx-auto" style="max-width: 700px;">Your journey to a global future is just three steps away. We've simplified the process to help you focus on your goals.</p>
            </div>

            <div class="row g-4 text-center mt-2">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="how-it-works-step p-4">
                        <div class="step-icon-wrapper mb-4">
                            <i class="fas fa-search"></i>
                            <span class="step-number">1</span>
                        </div>
                        <h4 class="fw-bold mb-3">Discover</h4>
                        <p class="text-muted">Browse through thousands of scholarships, internships, and university admissions tailored to your profile.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="how-it-works-step p-4">
                        <div class="step-icon-wrapper mb-4">
                            <i class="fas fa-file-signature"></i>
                            <span class="step-number">2</span>
                        </div>
                        <h4 class="fw-bold mb-3">Apply</h4>
                        <p class="text-muted">Use our AI-powered Resume Builder to create a professional CV and apply to opportunities with just one click.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="how-it-works-step p-4">
                        <div class="step-icon-wrapper mb-4">
                            <i class="fas fa-award"></i>
                            <span class="step-number">3</span>
                        </div>
                        <h4 class="fw-bold mb-3">Succeed</h4>
                        <p class="text-muted">Track your applications and get notified directly when you secure your dream opportunity. Shape your future today.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .how-it-works-step {
            transition: transform 0.3s ease;
        }
        .how-it-works-step:hover {
            transform: translateY(-5px);
        }
        .step-icon-wrapper {
            width: 100px;
            height: 100px;
            background: rgba(0, 33, 71, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            font-size: 2.5rem;
            color: var(--primary);
        }
        .step-number {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--accent-color);
            color: var(--primary);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
    </style>


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
                        <div class="premium-card-modern">
                            <div class="card-header-img" style="height: 180px; position: relative; overflow: hidden; background: #f8f9fa;">
                                @if($opp->image)
                                    <img src="{{ asset('storage/' . $opp->image) }}" alt="{{ $opp->title }}" style="width: 100%; height: 100%; object-fit: contain;">
                                @else
                                    <div class="h-100 w-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #002147 0%, #003366 100%); color: rgba(255,255,255,0.1); font-size: 4rem;">
                                        <i class="fas {{ $opp->type == 'scholarship' ? 'fa-graduation-cap' : ($opp->type == 'internship' ? 'fa-laptop-code' : 'fa-building') }}"></i>
                                    </div>
                                @endif
                                <div class="org-logo-absolute" style="position: absolute; bottom: -25px; left: 20px; width: 60px; height: 60px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-md); border: 2px solid white; overflow: hidden;">
                                    @if($opp->organization->logo)
                                        <img src="{{ asset('storage/' . $opp->organization->logo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; background: white;">
                                    @else
                                        <span class="fw-bold text-primary fs-4">{{ substr($opp->organization->organization_name, 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-4 pt-5">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge rounded-pill px-3 py-2 {{ $opp->type == 'scholarship' ? 'bg-primary-subtle text-primary' : 'bg-success-subtle text-success' }}">{{ ucfirst($opp->type) }}</span>
                                    <small class="text-muted"><i class="far fa-clock me-1"></i>
                                        {{ $opp->created_at->diffForHumans() }}</small>
                                </div>
                                <h5 class="fw-bold mb-2">
                                    <a href="{{ route('opportunities.show', $opp->id) }}"
                                        class="text-dark text-decoration-none hover-primary">
                                        {{ $opp->title }}
                                    </a>
                                </h5>
                                <p class="text-muted small mb-4">{{ $opp->organization->organization_name }} •
                                    {{ $opp->location ?? 'Pakistan' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <span class="fw-bold text-primary fs-5">{{ $opp->fees ? $opp->fees : 'Free' }}</span>
                                    <a href="{{ route('opportunities.show', $opp->id) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        View Details <i class="fas fa-arrow-right ms-1"></i>
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