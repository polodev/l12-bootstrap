<!-- Livewire Scripts (auto-starts) -->
@livewireScripts

<!-- Session and CSRF Error Handler -->
<script>
    // Global Livewire error handler for session expiration
    document.addEventListener('livewire:init', function () {
        // Handle Livewire errors globally
        Livewire.hook('request', ({ fail }) => {
            fail(({ status, content, preventDefault }) => {
                // Handle session expiration (419 status)
                if (status === 419) {
                    preventDefault();
                    
                    // Show user-friendly message
                    if (window.confirm('Your session has expired. Would you like to refresh the page?')) {
                        window.location.reload();
                    }
                    return;
                }
                
                // Handle other server errors (500, 503, etc.)
                if (status >= 500) {
                    preventDefault();
                    console.error('Server error:', status, content);
                    
                    // Show user-friendly error message
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white bg-red-500 transition-all duration-300';
                    toast.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span>Something went wrong. Please try again.</span>
                            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    document.body.appendChild(toast);
                    
                    // Auto remove after 5 seconds
                    setTimeout(() => toast.remove(), 5000);
                }
            });
        });
        
        // Refresh CSRF token periodically
        setInterval(() => {
            fetch('/refresh-csrf', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            }).then(response => response.json())
            .then(data => {
                if (data.token) {
                    document.querySelector('meta[name=csrf-token]').setAttribute('content', data.token);
                }
            }).catch(error => {
                console.error('CSRF refresh failed:', error);
            });
        }, 30 * 60 * 1000); // Every 30 minutes
    });
</script>

<!-- Toast Notification Handler -->
<script>
    // Toast notification handler
    document.addEventListener('livewire:init', function () {
        Livewire.on('toast', (event) => {
            console.log('Toast event received:', event);
            
            // Handle both array format and object format
            const data = Array.isArray(event) ? event[0] : event;
            
            if (!data || !data.message) {
                console.error('Invalid toast data:', data);
                return;
            }
            
            // Determine background color based on type
            let bgColor = 'bg-gray-500'; // default
            let icon = 'fa-info-circle'; // default
            
            switch(data.type) {
                case 'success':
                    bgColor = 'bg-green-500';
                    icon = 'fa-check-circle';
                    break;
                case 'error':
                    bgColor = 'bg-red-500';
                    icon = 'fa-exclamation-circle';
                    break;
                case 'warning':
                    bgColor = 'bg-yellow-500';
                    icon = 'fa-exclamation-triangle';
                    break;
                case 'info':
                    bgColor = 'bg-blue-500';
                    icon = 'fa-info-circle';
                    break;
            }
            
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transition-all duration-300 transform translate-x-full ${bgColor}`;
            toast.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${icon} mr-2"></i>
                    <span>${data.message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }, 5000);
        });
    });
</script>

<!-- Custom Scripts -->
@stack('scripts')