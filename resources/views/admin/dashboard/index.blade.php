@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between bg-white p-4 rounded-4 shadow-sm border-start border-primary border-5">
                <div>
                    <h2 class="fw-bold mb-0">System Overview</h2>
                    <p class="text-muted mb-0">Real-time platform analytics & management</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('M d, Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>



    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="glass-card p-4 border-bottom border-primary border-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-bold text-uppercase">Total Users</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-primary bg-opacity-10 p-3 shadow-sm">
                        <i class="fas fa-users text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4 border-bottom border-warning border-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small fw-bold text-uppercase">Organization Requests</p>
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_organizations'] }}</h3>
                    </div>
                    <div class="rounded-4 bg-warning bg-opacity-10 p-3 shadow-sm">
                        <i class="fas fa-university text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Charts -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="glass-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Platform Growth (Users)</h5>
                    <i class="fas fa-chart-line text-primary border rounded p-2"></i>
                </div>
                <div style="height: 300px;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Opportunity Breakdown</h5>
                    <i class="fas fa-chart-pie text-success border rounded p-2"></i>
                </div>
                <div style="height: 300px; position: relative;">
                    <canvas id="opportunityDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Organization Requests -->
    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Recent Organization Requests</h5>
                    <a href="{{ route('admin.organizations.pending') }}" class="btn btn-sm btn-outline-primary">
                        View All Requests
                    </a>
                </div>

                @if($recentOrganizations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Organization Name</th>
                                    <th>Registration ID</th>
                                    <th>Location</th>
                                    <th>Date Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrganizations as $org)
                                    <tr>
                                        <td>
                                            @if($org->logo)
                                                <img src="{{ asset('storage/' . $org->logo) }}" alt="Logo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: contain; background: white;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-university text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ $org->organization_name }}</td>
                                        <td><code>{{ $org->registration_id }}</code></td>
                                        <td>{{ $org->location }}</td>
                                        <td>{{ $org->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.organizations.show', $org->id) }}"
                                                class="btn btn-sm btn-primary">Review</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No pending registration requests</p>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- User Growth Chart ---
            const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData['userGrowth']['labels']) !!},
                    datasets: [{
                        label: 'New Users',
                        data: {!! json_encode($chartData['userGrowth']['data']) !!},
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: { precision: 0 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // --- Opportunity Distribution Chart ---
            const distCtx = document.getElementById('opportunityDistributionChart').getContext('2d');
            new Chart(distCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartData['opportunityDistribution']['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($chartData['opportunityDistribution']['data']) !!},
                        backgroundColor: [
                            '#6c5ce7', // Admission
                            '#00b894', // Internship
                            '#fdcb6e'  // Scholarship
                        ],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
@endsection