<div class="space-y-1">
    @if($coupon->starts_at)
    <div class="text-xs text-gray-600 dark:text-gray-400">
        <span class="font-medium">Start:</span> {{ $coupon->starts_at->format('M j, Y') }}
    </div>
    @endif
    
    @if($coupon->expires_at)
    <div class="text-xs {{ $coupon->expires_at->isPast() ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
        <span class="font-medium">{{ $coupon->expires_at->isPast() ? 'Expired:' : 'Expires:' }}</span> {{ $coupon->expires_at->format('M j, Y') }}
    </div>
    @else
    <div class="text-xs text-gray-600 dark:text-gray-400">
        <span class="font-medium">Never expires</span>
    </div>
    @endif
</div>