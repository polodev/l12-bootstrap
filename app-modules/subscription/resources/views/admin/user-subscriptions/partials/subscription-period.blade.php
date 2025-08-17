<div class="space-y-1">
    <div class="text-xs text-gray-600 dark:text-gray-400">
        <span class="font-medium">Start:</span> {{ $subscription->starts_at->format('M j, Y') }}
    </div>
    <div class="text-xs text-gray-600 dark:text-gray-400">
        <span class="font-medium">End:</span> {{ $subscription->ends_at->format('M j, Y') }}
    </div>
    @if($subscription->status === 'active')
        @php
            $daysRemaining = $subscription->ends_at->diffInDays(now());
        @endphp
        <div class="text-xs {{ $daysRemaining > 7 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
            {{ $daysRemaining }} days remaining
        </div>
    @endif
</div>