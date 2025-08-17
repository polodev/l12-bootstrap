<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Subscription Plan</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update subscription plan with multilingual support</p>
                </div>
                <a href="{{ route('subscription::admin.plans.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('subscription::admin.plans.update', $plan) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Plan Name *
                        </label>
                        <input type="text" 
                               id="name"
                               name="name"
                               value="{{ old('name', $plan->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="e.g., pro"
                               required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Usually just "pro" - the actual titles are handled by plan_title field below</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug (Auto-generated, can be changed)
                        </label>
                        <input type="text" 
                               id="slug"
                               name="slug"
                               value="{{ old('slug', $plan->slug) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Auto-generated from name">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pricing Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Price *
                        </label>
                        <input type="number" 
                               id="price"
                               name="price"
                               value="{{ old('price', $plan->price) }}"
                               step="0.01"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Duration (Months) *
                        </label>
                        <select id="duration_months" 
                                name="duration_months"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Select Duration</option>
                            <option value="1" {{ old('duration_months', $plan->duration_months) == 1 ? 'selected' : '' }}>1 Month</option>
                            <option value="3" {{ old('duration_months', $plan->duration_months) == 3 ? 'selected' : '' }}>3 Months</option>
                            <option value="6" {{ old('duration_months', $plan->duration_months) == 6 ? 'selected' : '' }}>6 Months</option>
                            <option value="12" {{ old('duration_months', $plan->duration_months) == 12 ? 'selected' : '' }}>12 Months</option>
                        </select>
                        @error('duration_months')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Currency *
                        </label>
                        <input type="text" 
                               id="currency"
                               name="currency"
                               value="{{ old('currency', $plan->currency) }}"
                               maxlength="3"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                        @error('currency')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status and Sort Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Status -->
                    <div>
                        <div class="flex items-center">
                            <input id="is_active" 
                                   name="is_active" 
                                   type="checkbox" 
                                   value="1"
                                   {{ old('is_active', $plan->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Active Plan
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Sort Order
                        </label>
                        <input type="number" 
                               id="sort_order"
                               name="sort_order"
                               value="{{ old('sort_order', $plan->sort_order) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Brief description of the plan">{{ old('description', $plan->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Plan Title Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Plan Titles</h3>

                    <!-- Language Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button type="button" 
                                    class="title-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                    data-tab="en" 
                                    data-active="true">
                                English Title
                            </button>
                            <button type="button" 
                                    class="title-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                    data-tab="bn" 
                                    data-active="false">
                                Bengali Title
                            </button>
                        </nav>
                    </div>

                    <!-- English Title Tab -->
                    <div id="title-tab-en" class="title-tab-panel">
                        <div>
                            <label for="plan_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Plan Title (English) *
                            </label>
                            <input type="text" 
                                   id="plan_title_en"
                                   name="plan_title[en]"
                                   value="{{ old('plan_title.en', $plan->getTranslation('plan_title', 'en')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., Pro Monthly, Pro Quarterly"
                                   required>
                            @error('plan_title.en')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bengali Title Tab -->
                    <div id="title-tab-bn" class="title-tab-panel hidden">
                        <div>
                            <label for="plan_title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Plan Title (Bengali)
                            </label>
                            <input type="text" 
                                   id="plan_title_bn"
                                   name="plan_title[bn]"
                                   value="{{ old('plan_title.bn', $plan->getTranslation('plan_title', 'bn')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., প্রো মাসিক, প্রো ত্রৈমাসিক">
                            @error('plan_title.bn')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Features Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Features</h3>

                    <!-- Features Language Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button type="button" 
                                    class="features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                    data-tab="en" 
                                    data-active="true">
                                English Features
                            </button>
                            <button type="button" 
                                    class="features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                    data-tab="bn" 
                                    data-active="false">
                                Bengali Features
                            </button>
                        </nav>
                    </div>

                    <!-- English Features Tab -->
                    <div id="features-tab-en" class="features-tab-panel">
                        <div>
                            <label for="features_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Features (English)
                            </label>
                            <textarea id="features_en"
                                      name="features[en]"
                                      rows="8"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="List plan features in English (supports Markdown)">{{ old('features.en', $plan->getTranslation('features', 'en')) }}</textarea>
                            @error('features.en')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bengali Features Tab -->
                    <div id="features-tab-bn" class="features-tab-panel hidden">
                        <div>
                            <label for="features_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Features (Bengali)
                            </label>
                            <textarea id="features_bn"
                                      name="features[bn]"
                                      rows="8"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="বাংলায় প্ল্যানের ফিচার লিস্ট (Markdown সাপোর্ট করে)">{{ old('features.bn', $plan->getTranslation('features', 'bn')) }}</textarea>
                            @error('features.bn')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('subscription::admin.plans.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Plan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-generate slug from name
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            let manualSlugEdit = false;

            // Check if slug was manually edited
            slugInput.addEventListener('input', function() {
                manualSlugEdit = true;
            });

            // Auto-generate slug when name changes
            nameInput.addEventListener('input', function() {
                if (!manualSlugEdit) {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    slugInput.value = slug;
                }
            });

            // Title Tab functionality
            const titleTabButtons = document.querySelectorAll('.title-tab-btn');
            const titleTabPanels = document.querySelectorAll('.title-tab-panel');

            titleTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update button states
                    titleTabButtons.forEach(btn => {
                        btn.setAttribute('data-active', 'false');
                        btn.className = 'title-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500';
                    });
                    
                    this.setAttribute('data-active', 'true');
                    this.className = 'title-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400';
                    
                    // Update panel visibility
                    titleTabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    
                    document.getElementById(`title-tab-${targetTab}`).classList.remove('hidden');
                });
            });

            // Features Tab functionality
            const featuresTabButtons = document.querySelectorAll('.features-tab-btn');
            const featuresTabPanels = document.querySelectorAll('.features-tab-panel');

            featuresTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update button states
                    featuresTabButtons.forEach(btn => {
                        btn.setAttribute('data-active', 'false');
                        btn.className = 'features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500';
                    });
                    
                    this.setAttribute('data-active', 'true');
                    this.className = 'features-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400';
                    
                    // Update panel visibility
                    featuresTabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    
                    document.getElementById(`features-tab-${targetTab}`).classList.remove('hidden');
                });
            });

            // Initialize EasyMDE for features fields
            const easyMDEEn = new EasyMDE({
                element: document.getElementById('features_en'),
                spellChecker: false,
                placeholder: 'List plan features in English (supports Markdown)',
                toolbar: [
                    'bold', 'italic', 'strikethrough', '|',
                    'heading-1', 'heading-2', 'heading-3', '|',
                    'unordered-list', 'ordered-list', '|',
                    'link', 'quote', 'code', '|',
                    'preview', 'side-by-side', 'fullscreen', '|',
                    'guide'
                ]
            });

            const easyMDEBn = new EasyMDE({
                element: document.getElementById('features_bn'),
                spellChecker: false,
                placeholder: 'বাংলায় প্ল্যানের ফিচার লিস্ট (Markdown সাপোর্ট করে)',
                toolbar: [
                    'bold', 'italic', 'strikethrough', '|',
                    'heading-1', 'heading-2', 'heading-3', '|',
                    'unordered-list', 'ordered-list', '|',
                    'link', 'quote', 'code', '|',
                    'preview', 'side-by-side', 'fullscreen', '|',
                    'guide'
                ]
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>