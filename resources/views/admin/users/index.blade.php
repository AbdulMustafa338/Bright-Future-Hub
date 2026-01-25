@extends('layouts.dashboard')

@section('title', 'Manage Users')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Manage Users</h2>
            <p class="text-muted">View and manage all platform users</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="glass-card p-4">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td class="fw-bold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->role === 'organization')
                                                <span class="badge bg-primary">Organization</span>
                                            @else
                                                <span class="badge bg-info">Student</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            @if($user->role !== 'admin')
                                                <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @if($user->is_active)
                                                        <button type="submit" class="btn btn-sm btn-outline-warning"
                                                            onclick="return confirm('Are you sure you want to deactivate this user?')">
                                                            <i class="fas fa-ban me-1"></i>Deactivate
                                                        </button>
                                                    @else
                                                        <button type="submit" class="btn btn-sm btn-outline-success"
                                                            onclick="return confirm('Are you sure you want to activate this user?')">
                                                            <i class="fas fa-check me-1"></i>Activate
                                                        </button>
                                                    @endif
                                                </form>
                                            @else
                                                <span class="text-muted small">Admin User</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($users->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">No users found</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection