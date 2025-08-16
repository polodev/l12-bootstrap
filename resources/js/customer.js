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

// Customer-specific JavaScript functionality

// Customer form helpers
window.CustomerForm = {
    // Show loading state on form submission
    showLoading: function(form, message = 'Processing...') {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            const icon = submitBtn.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-spinner fa-spin mr-2';
            }
            const textNode = submitBtn.childNodes[submitBtn.childNodes.length - 1];
            if (textNode && textNode.nodeType === Node.TEXT_NODE) {
                textNode.textContent = message;
            }
        }
    },
    
    // Reset form loading state
    resetLoading: function(form, originalText = 'Submit', originalIcon = 'fas fa-save mr-2') {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = false;
            const icon = submitBtn.querySelector('i');
            if (icon) {
                icon.className = originalIcon;
            }
            const textNode = submitBtn.childNodes[submitBtn.childNodes.length - 1];
            if (textNode && textNode.nodeType === Node.TEXT_NODE) {
                textNode.textContent = originalText;
            }
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

// Customer toast notifications (Livewire integration)
window.CustomerToast = {
    show: function(message, type = 'info', duration = 5000) {
        // This will be handled by the Livewire toast handler in the layout
        // But we can also trigger it programmatically
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message, type }
        }));
    }
};

// Theme switching functionality - use the same setAppearance function from head
// No need for separate CustomerTheme since setAppearance is already defined in head

// Mobile menu helpers
window.CustomerMobile = {
    toggleMenu: function(menuId) {
        const menu = document.getElementById(menuId);
        if (menu) {
            menu.classList.toggle('hidden');
        }
    },
    
    closeMenu: function(menuId) {
        const menu = document.getElementById(menuId);
        if (menu) {
            menu.classList.add('hidden');
        }
    },
    
    openMenu: function(menuId) {
        const menu = document.getElementById(menuId);
        if (menu) {
            menu.classList.remove('hidden');
        }
    }
};

// Customer profile helpers
window.CustomerProfile = {
    // Copy text to clipboard
    copyToClipboard: function(text, successMessage = 'Copied to clipboard!') {
        navigator.clipboard.writeText(text).then(() => {
            window.CustomerToast.show(successMessage, 'success');
        }).catch(() => {
            window.CustomerToast.show('Failed to copy to clipboard', 'error');
        });
    },
    
    // Format phone number display
    formatPhoneNumber: function(countryCode, number) {
        return `${countryCode} ${number}`;
    },
    
    // Validate email format
    isValidEmail: function(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },
    
    // Validate phone number (basic)
    isValidPhone: function(phone) {
        const phoneRegex = /^[\d\s\-\+\(\)]+$/;
        return phoneRegex.test(phone) && phone.replace(/\D/g, '').length >= 7;
    }
};

// Initialize customer-specific functionality
document.addEventListener('DOMContentLoaded', function() {
    // Theme is already initialized by setAppearance() in head section
    
    // Auto-close mobile menus when clicking outside
    document.addEventListener('click', function(e) {
        const mobileMenus = document.querySelectorAll('.customer-mobile-menu');
        mobileMenus.forEach(menu => {
            if (!menu.contains(e.target) && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    });
    
    // Form validation for customer forms
    document.querySelectorAll('.customer-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!window.CustomerForm.validateRequired(this)) {
                e.preventDefault();
                window.CustomerToast.show('Please fill in all required fields', 'error');
            }
        });
    });
    
    // Initialize copy-to-clipboard buttons
    document.querySelectorAll('[data-copy]').forEach(btn => {
        btn.addEventListener('click', function() {
            const text = this.getAttribute('data-copy');
            window.CustomerProfile.copyToClipboard(text);
        });
    });
});

