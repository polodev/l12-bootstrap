<div class="space-y-1">
    <div class="font-bold text-gray-900 dark:text-gray-100">
        @if($coupon->type === 'percentage')
            {{ number_format($coupon->value, 1) }}% OFF
        @else
            {{ number_format($coupon->value, 2) }} BDT OFF
        @endif
    </div>
    @if($coupon->type === 'percentage' && $coupon->maximum_discount)
    <div class="text-xs text-gray-500 dark:text-gray-400">Max: {{ number_format($coupon->maximum_discount, 2) }} BDT</div>
    @endif
    @if($coupon->minimum_amount)
    <div class="text-xs text-gray-500 dark:text-gray-400">Min: {{ number_format($coupon->minimum_amount, 2) }} BDT</div>
    @endif
</div>