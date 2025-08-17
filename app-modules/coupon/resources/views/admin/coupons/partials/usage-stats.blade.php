<div class="space-y-1">
    <div class="font-bold text-gray-900 dark:text-gray-100">{{ $coupon->usages_count ?? 0 }} uses</div>
    @if($coupon->usage_limit)
    <div class="text-xs text-gray-500 dark:text-gray-400">
        {{ number_format((($coupon->usages_count ?? 0) / $coupon->usage_limit) * 100, 1) }}% used
    </div>
    <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, (($coupon->usages_count ?? 0) / $coupon->usage_limit) * 100) }}%"></div>
    </div>
    @endif
</div>