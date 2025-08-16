<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name') }}</title>

<!-- Theme Script -->
<script>
    // Unified theme management - shared localStorage key 'appearance'
    window.themeManager = {
        storageKey: 'appearance',
        
        setDark() {
            document.documentElement.classList.add('dark')
        },
        
        setLight() {
            document.documentElement.classList.remove('dark')
        },
        
        setButtons(appearance) {
            document.querySelectorAll('button[onclick^="setAppearance"]').forEach((button) => {
                const buttonValue = button.getAttribute('onclick').match(/'([^']+)'/)?.[1]
                button.setAttribute('aria-pressed', String(appearance === buttonValue))
            })
        },
        
        applyTheme(appearance) {
            if (appearance === 'system') {
                const media = window.matchMedia('(prefers-color-scheme: dark)')
                media.matches ? this.setDark() : this.setLight()
                
                // Listen for system theme changes
                if (!window.systemThemeListener) {
                    window.systemThemeListener = (e) => {
                        if (!localStorage.getItem(this.storageKey)) {
                            e.matches ? this.setDark() : this.setLight()
                        }
                    }
                    media.addEventListener('change', window.systemThemeListener)
                }
            } else if (appearance === 'dark') {
                this.setDark()
            } else if (appearance === 'light') {
                this.setLight()
            }
        },
        
        init() {
            const savedTheme = localStorage.getItem(this.storageKey) || 'system'
            this.applyTheme(savedTheme)
            
            // Update buttons when DOM is ready
            if (document.readyState === 'complete') {
                this.setButtons(savedTheme)
            } else {
                document.addEventListener("DOMContentLoaded", () => this.setButtons(savedTheme))
            }
            
            // Listen for storage changes from other tabs/windows
            window.addEventListener('storage', (e) => {
                if (e.key === this.storageKey) {
                    const newTheme = e.newValue || 'system'
                    this.applyTheme(newTheme)
                    this.setButtons(newTheme)
                }
            })
        }
    }
    
    window.setAppearance = function(appearance) {
        if (appearance === 'system') {
            localStorage.removeItem(window.themeManager.storageKey)
        } else {
            localStorage.setItem(window.themeManager.storageKey, appearance)
        }
        
        window.themeManager.applyTheme(appearance)
        window.themeManager.setButtons(appearance)
    }
    
    // Initialize theme management
    window.themeManager.init()
</script>

<!-- Livewire Styles -->
@livewireStyles

<!-- Customer Styles and Scripts -->
@vite(['resources/css/customer.css', 'resources/js/customer.js'])
@stack('styles')