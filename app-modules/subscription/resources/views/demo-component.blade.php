<x-customer-frontend-layout::layout>
    <x-slot name="title">Subscription Component Demo</x-slot>
    
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Subscription Component Demo</h1>
                <p class="text-gray-600 dark:text-gray-400">Example usage of the reusable subscription component</p>
            </div>

            <!-- Component Usage Example -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Usage Example</h2>
                <div class="bg-gray-100 dark:bg-gray-700 rounded p-4">
                    <code class="text-sm text-gray-800 dark:text-gray-200">
                        &lt;livewire:subscription--active-subscription :user="$user" /&gt;
                    </code>
                </div>
            </div>

            <!-- Live Component Demo -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Live Component</h2>
                @auth
                    <livewire:subscription--active-subscription :user="Auth::user()" />
                @else
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <p class="text-yellow-800 dark:text-yellow-200">
                            Please <a href="{{ route('login') }}" class="underline">login</a> to see the subscription component.
                        </p>
                    </div>
                @endauth
            </div>

            <!-- Component Features -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Component Features</h2>
                <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-400">
                    <li>✅ Reusable across different pages (pricing, profile, account)</li>
                    <li>✅ Automatically calculates subscription status (active, upcoming, expired)</li>
                    <li>✅ Shows combined validity for subscription extensions</li>
                    <li>✅ Validates payment completion before displaying</li>
                    <li>✅ Responsive design with dark mode support</li>
                    <li>✅ Multilingual support (English/Bengali)</li>
                    <li>✅ Shows appropriate fallback when no subscription exists</li>
                    <li>✅ Real-time days calculation</li>
                </ul>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>