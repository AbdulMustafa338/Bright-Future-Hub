@extends('layouts.dashboard')

@section('title', 'Pending Organizations')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="glass-card p-4 border-start border-warning border-5">
            <h2 class="fw-bold mb-0 text-warning">Organization Verification Requests</h2>
            <p class="text-muted">Review and verify institution registration details.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="glass-card p-4">
            @if($organizations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Reg ID</th>
                                <th>Location</th>
                                <th>Email</th>
                                <th>Submitted</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organizations as $org)
                                <tr>
                                    <td>
                                        @if($org->logo)
                                            <img src="{{ asset('storage/' . $org->logo) }}" alt="Logo" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 1px solid #eee;">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; border: 1px solid #eee;">
                                                <i class="fas fa-university text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $org->organization_name }}</div>
                                        <small class="text-muted">{{ $org->user->name }}</small>
                                    </td>
                                    <td><code>{{ $org->registration_id }}</code></td>
                                    <td>{{ $org->location }}</td>
                                    <td>{{ $org->user->email }}</td>
                                    <td>{{ $org->created_at->diffForHumans() }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.organizations.show', $org->id) }}" class="btn btn-primary btn-sm px-3">
                                            <i class="fas fa-search me-1"></i> Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $organizations->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success fs-1"></i>
                    </div>
                    <h4 class="fw-bold">All caught up!</h4>
                    <p class="text-muted">There are no pending organization requests at the moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
