@props([
    'title' => 'Card Title',
    'collapsed' => true,
    'cardClass' => 'border border-gray-200 dark:border-gray-700',
    'headerClass' => 'bg-green-500 text-white',
    'contentClass' => 'bg-white dark:bg-gray-800'
])

<div class="rounded-lg shadow-sm {{ $cardClass }}" x-data="{ isOpen: {{ $collapsed ? 'false' : 'true' }} }">
    <!-- Header -->
    <div 
        class="px-4 py-3 rounded-t-lg cursor-pointer flex justify-between items-center {{ $headerClass }}"
        @click="isOpen = !isOpen"
    >
        <h3 class="text-sm font-medium">{{ $title }}</h3>
        <svg 
            class="w-5 h-5 transform transition-transform duration-200" 
            :class="{ 'rotate-180': isOpen }"
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <!-- Content -->
    <div 
        class="overflow-hidden transition-all duration-300 {{ $contentClass }}"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
    >
        <div class="p-4">
            {{ $slot }}
        </div>
    </div>
</div>