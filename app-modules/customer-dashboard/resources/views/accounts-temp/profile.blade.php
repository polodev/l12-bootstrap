<x-customer-account-layout::layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="bg-white rounded shadow-sm p-4">
                    <!-- Breadcrumbs -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('accounts.index') }}">{{ __('messages.my_account') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ __('messages.profile') }}</li>
                        </ol>
                    </nav>

                    <h1 class="h3 mb-4">{{ __('messages.my_profile') }}</h1>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ __('messages.profile_information') }}</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('accounts.settings.profile.update') }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            {{ __('messages.update_profile') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ __('messages.account_info') }}</h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>{{ __('messages.member_since') }}:</strong><br>
                                       {{ $user->created_at->format('F d, Y') }}</p>
                                    
                                    <p><strong>{{ __('messages.email_status') }}:</strong><br>
                                       @if($user->email_verified_at)
                                           <span class="badge bg-success">{{ __('messages.verified') }}</span>
                                       @else
                                           <span class="badge bg-warning">{{ __('messages.not_verified') }}</span>
                                       @endif
                                    </p>

                                    @if($user->role)
                                        <p><strong>{{ __('messages.roles') }}:</strong><br>
                                           <span class="badge bg-secondary me-1">{{ Str::headline($user->role) }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Password Change Link -->
                            <div class="card mt-3">
                                <div class="card-body text-center">
                                    <h6 class="card-title">{{ __('messages.password_security') }}</h6>
                                    <a href="{{ route('accounts.settings.password.edit') }}" class="btn btn-outline-primary btn-sm">
                                        {{ __('messages.change_password') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-account-layout::layout>