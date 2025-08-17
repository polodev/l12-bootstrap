<div class="space-y-1">
    <div class="font-medium text-gray-900 dark:text-gray-100">{{ number_format($subscription->paid_amount, 2) }} {{ $subscription->currency }}</div>
    @if($subscription->discount_amount > 0)
    <div class="text-xs text-green-600 dark:text-green-400">Discount: -{{ number_format($subscription->discount_amount, 2) }} {{ $subscription->currency }}</div>
    @endif
    @if($subscription->payment)
    <div class="text-xs text-gray-500 dark:text-gray-400">Payment #{{ $subscription->payment->id }}</div>
    @endif
</div>