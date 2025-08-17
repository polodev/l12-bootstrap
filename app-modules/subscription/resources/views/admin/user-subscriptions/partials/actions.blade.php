<div class="flex items-center gap-1">
    <a href="{{ route('subscription::admin.subscriptions.show', $subscription) }}" 
       class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
       title="View Details">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
    </a>
    
    @if($subscription->status === 'active')
    <form action="{{ route('subscription::admin.subscriptions.cancel', $subscription) }}" method="POST" class="inline">
        @csrf
        <button type="submit" 
                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                title="Cancel Subscription"
                onclick="return confirm('Are you sure you want to cancel this subscription?')">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </form>
    @endif
    
    @if($subscription->payment)
    <a href="{{ route('payment::admin.payments.show', $subscription->payment) }}" 
       class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
       title="View Payment">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
    </a>
    @endif
</div>