<div class="space-y-1">
    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $coupon->used_count }}</div>
    <div class="text-xs text-gray-500 dark:text-gray-400">
        @if($coupon->usage_limit)
            of {{ $coupon->usage_limit }} uses
        @else
            unlimited uses
        @endif
    </div>
    @if($coupon->usage_limit_per_user)
    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $coupon->usage_limit_per_user }}/user max</div>
    @endif
</div>