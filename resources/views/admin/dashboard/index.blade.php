@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Admin Dashboard</h2>
            <p class="text-muted">Manage users, organizations, and opportunities</p>
        </div>
    </div>



    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Total Users</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-users text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Pending Approvals</p>
                        <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-clock text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Approved Opportunities</p>
                        <h3 class="fw-bold mb-0 text-success">{{ $stats['approved_opportunities'] }}</h3>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-check-circle text-success fs-4"></i>
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
                    <h5 class="fw-bold mb-0">User Growth (Last 30 Days)</h5>
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
                    <h5 class="fw-bold mb-0">Opportunity Types</h5>
                    <i class="fas fa-chart-pie text-success border rounded p-2"></i>
                </div>
                <div style="height: 300px; position: relative;">
                    <canvas id="opportunityDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Opportunities -->
    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Recent Opportunities</h5>
                    <a href="{{ route('admin.opportunities.pending') }}" class="btn btn-sm btn-outline-primary">
                        View All Pending
                    </a>
                </div>

                @if($recentOpportunities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Organization</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Deadline</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOpportunities as $opp)
                                    <tr>
                                        <td class="fw-bold">{{ $opp->title }}</td>
                                        <td>{{ $opp->organization->organization_name }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($opp->type) }}</span>
                                        </td>
                                        <td>
                                            @if($opp->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($opp->status === 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $opp->deadline->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('opportunities.show', $opp->id) }}"
                                                class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">No opportunities yet</p>
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
                            '#0d6efd', // Job
                            '#198754', // Internship
                            '#ffc107'  // Scholarship
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