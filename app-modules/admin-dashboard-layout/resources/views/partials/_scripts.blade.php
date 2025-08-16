<!-- Livewire Scripts -->
@livewireScripts

<!-- Admin JavaScript -->
@vite(['resources/js/admin.js'])

<!-- Admin Toast Notification Handler -->
<script>
    // Admin toast notification handler
    document.addEventListener('livewire:init', function () {
        Livewire.on('toast', (event) => {
            console.log('Admin Toast event received:', event);
            
            // Handle both array format and object format
            const data = Array.isArray(event) ? event[0] : event;
            
            if (!data || !data.message) {
                console.error('Invalid toast data:', data);
                return;
            }
            
            // Use AdminToast if available, fallback to basic implementation
            if (window.AdminToast) {
                window.AdminToast.show(data.message, data.type || 'info');
            } else {
                // Fallback basic toast
                alert(`${data.type?.toUpperCase() || 'INFO'}: ${data.message}`);
            }
        });
    });
</script>


