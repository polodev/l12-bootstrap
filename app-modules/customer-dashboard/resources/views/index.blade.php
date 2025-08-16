<x-customer-account-layout::layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="bg-white rounded shadow-sm p-4">
                    <h1 class="h3 mb-4">{{ __('messages.dashboard') }}</h1>
                    <p class="lead">{{ __('messages.welcome_dashboard') }}</p>
                    
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">{{ __('messages.my_profile') }}</h5>
                                    <p class="card-text">{{ __('messages.manage_profile_info') }}</p>
                                    <a href="#" class="btn btn-primary">
                                        {{ __('messages.view_profile') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="fas fa-shopping-cart fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">{{ __('messages.my_orders') }}</h5>
                                    <p class="card-text">{{ __('messages.track_orders') }}</p>
                                    <a href="#" class="btn btn-info">
                                        {{ __('messages.view_orders') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-heart fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">{{ __('messages.wishlist') }}</h5>
                                    <p class="card-text">{{ __('messages.saved_items') }}</p>
                                    <a href="#" class="btn btn-success">
                                        {{ __('messages.view_wishlist') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <i class="fas fa-headset fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">{{ __('messages.support') }}</h5>
                                    <p class="card-text">{{ __('messages.get_help') }}</p>
                                    <a href="#" class="btn btn-warning">
                                        {{ __('messages.contact_support') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border-secondary">
                                <div class="card-body text-center">
                                    <i class="fas fa-cog fa-3x text-secondary mb-3"></i>
                                    <h5 class="card-title">{{ __('messages.settings') }}</h5>
                                    <p class="card-text">{{ __('messages.account_settings') }}</p>
                                    <a href="#" class="btn btn-secondary">
                                        {{ __('messages.manage_settings') }}
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
