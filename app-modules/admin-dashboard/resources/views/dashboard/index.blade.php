<x-admin-dashboard-layout::layout>
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Admin Dashboard</h1>
            <small class="text-muted">Welcome back, {{ auth()->user()->name }}!</small>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_users']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Verified Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['verified_users']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Unverified Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['unverified_users']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-times fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    New This Month
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['users_this_month']) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Role Distribution Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">User Role Distribution</h6>
                    </div>
                    <div class="card-body">
                        @if($roleStats->count() > 0)
                            <div class="row">
                                @foreach($roleStats as $role => $count)
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="small">{{ Str::headline($role) }}</span>
                                            <span class="small font-weight-bold">{{ $count }}</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" 
                                                 style="width: {{ ($count / $stats['total_users']) * 100 }}%" 
                                                 aria-valuenow="{{ $count }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="{{ $stats['total_users'] }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <p>No user role data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                        <a href="{{ route('admin-dashboard.users.index') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>
                    <div class="card-body">
                        @if($recentUsers->count() > 0)
                            @foreach($recentUsers as $user)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="mr-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="small font-weight-bold">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                        @if($user->role)
                                            <span class="badge badge-secondary badge-sm">{{ $user->role }}</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <div class="small text-muted">{{ $user->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-user-plus fa-2x mb-2"></i>
                                <p>No users found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin-dashboard.users.index') }}" class="btn btn-outline-primary btn-block">
                                    <i class="fas fa-users mr-1"></i>
                                    Manage Users
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('admin-dashboard.users.create') }}" class="btn btn-outline-success btn-block">
                                    <i class="fas fa-user-plus mr-1"></i>
                                    Add New User
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-info btn-block">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    View Reports
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-warning btn-block">
                                    <i class="fas fa-cog mr-1"></i>
                                    System Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }
        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }
        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }
        .progress-sm {
            height: 0.5rem;
        }
    </style>
    @endpush
</x-admin-dashboard-layout::layout>