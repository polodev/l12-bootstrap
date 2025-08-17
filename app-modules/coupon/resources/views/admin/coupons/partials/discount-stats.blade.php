<div class="space-y-1">
    <div class="font-bold text-green-600 dark:text-green-400">
        {{ number_format($coupon->usages_sum_discount_amount ?? 0, 2) }} BDT
    </div>
    <div class="text-xs text-gray-500 dark:text-gray-400">Total savings</div>
    @if($coupon->usages_count > 0)
    <div class="text-xs text-gray-500 dark:text-gray-400">
        Avg: {{ number_format(($coupon->usages_sum_discount_amount ?? 0) / $coupon->usages_count, 2) }} BDT
    </div>
    @endif
</div>