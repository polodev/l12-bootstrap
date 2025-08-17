<div class="space-y-1">
    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $subscription->user->name ?? 'Unknown User' }}</div>
    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->user->email ?? 'N/A' }}</div>
    @if($subscription->user && $subscription->user->mobile)
    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->user->mobile }}</div>
    @endif
</div>