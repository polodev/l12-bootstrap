import axios from "axios";
import Alpine from "alpinejs";

// Setup axios
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// Setup Alpine but don't auto-start
window.Alpine = Alpine;

// Start Alpine after Livewire is ready
document.addEventListener('DOMContentLoaded', function() {
    let alpineStarted = false;
    
    function startAlpine() {
        if (!alpineStarted) {
            alpineStarted = true;
            Alpine.start();
        }
    }
    
    // Check if Livewire is available
    if (window.Livewire) {
        // Listen for Livewire to be ready
        document.addEventListener('livewire:init', startAlpine);
        
        // Fallback in case the event already fired
        setTimeout(startAlpine, 100);
    } else {
        // No Livewire, start Alpine normally
        startAlpine();
    }
});

// Admin-specific JavaScript functionality


// Flatpickr initialization helper
window.initDatePicker = function(selector, options = {}) {
    const defaultOptions = {
        dateFormat: "Y-m-d",
        allowInput: true,
        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
    };
    
    return flatpickr(selector, {...defaultOptions, ...options});
};

// Select2 initialization helper
window.initSelect2 = function(selector, options = {}) {
    const defaultOptions = {
        theme: 'default',
        width: '100%'
    };
    
    return $(selector).select2({...defaultOptions, ...options});
};


// Admin form helpers
window.AdminForm = {
    // Show loading state on form submission
    showLoading: function(form, message = 'Processing...') {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i>${message}`;
        }
    },
    
    // Reset form loading state
    resetLoading: function(form, originalText = 'Submit') {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    },
    
    // Validate required fields
    validateRequired: function(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        return isValid;
    }
};

// Admin toast notifications
window.AdminToast = {
    show: function(message, type = 'info', duration = 5000) {
        let bgColor = 'bg-blue-500';
        let icon = 'fa-info-circle';
        
        switch(type) {
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
        }
        
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white transition-all duration-300 transform translate-x-full ${bgColor}`;
        toast.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${icon} mr-2"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }
};

// Initialize common admin components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Auto-initialize date pickers with .admin-datepicker class
    document.querySelectorAll('.admin-datepicker').forEach(input => {
        window.initDatePicker(input);
    });
    
    // Auto-initialize Select2 with .admin-select2 class
    document.querySelectorAll('.admin-select2').forEach(select => {
        window.initSelect2(select);
    });
    
    // Form validation on submit
    document.querySelectorAll('.admin-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!window.AdminForm.validateRequired(this)) {
                e.preventDefault();
                window.AdminToast.show('Please fill in all required fields', 'error');
            }
        });
    });
});

