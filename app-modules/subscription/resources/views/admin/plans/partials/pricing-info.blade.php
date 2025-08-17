<div class="space-y-1">
    <div class="font-bold text-gray-900 dark:text-gray-100">{{ $plan->formatted_price }}</div>
    <div class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($plan->price_per_month, 2) }} BDT/month</div>
    @if($plan->savings > 0)
    <div class="text-xs text-green-600 dark:text-green-400">Save {{ number_format($plan->savings, 2) }} BDT</div>
    @endif
</div>