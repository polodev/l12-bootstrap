<div class="space-y-1">
    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $subscription->subscriptionPlan->name ?? 'Unknown Plan' }}</div>
    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->subscriptionPlan->duration_text ?? '' }}</div>
    @if($subscription->coupon_code)
    <div class="text-xs text-green-600 dark:text-green-400">Coupon: {{ $subscription->coupon_code }}</div>
    @endif
</div>