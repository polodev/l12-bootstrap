<?php

use function Livewire\Volt\{state, computed};
use Modules\Subscription\Models\UserSubscription;

state(['user']);

$subscriptionInfo = computed(function () {
    if (!$this->user) {
        return [
            'has_subscription' => false,
            'overall_status' => 'none',
            'display_subscription' => null,
            'subscription_period' => null,
            'days_remaining' => 0,
            'total_subscriptions' => 0,
            'is_expiring_soon' => false,
            'is_expired' => false,
        ];
    }
    
    // Single efficient function call that returns everything we need
    return UserSubscription::getCompleteSubscriptionInfo($this->user->id);
});

?>

<div>
    @if($this->subscriptionInfo['has_subscription'])
        <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 shadow-sm">
            <div class="text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.active_subscription') }}</h2>
                        <p class="text-green-600 dark:text-green-400 font-medium">{{ $this->subscriptionInfo['display_subscription']->subscriptionPlan->name }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.status') }}</div>
                        <div class="font-semibold text-green-600 dark:text-green-400 capitalize">
                            {{ $this->subscriptionInfo['overall_status'] }}
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.started_on') }}</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            {{ $this->subscriptionInfo['subscription_period']['starts_at']->format('M j, Y') }}
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center">
                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.expires_on') }}</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            {{ $this->subscriptionInfo['subscription_period']['ends_at']->format('M j, Y') }}
                        </div>
                    </div>
                </div>
                
                @php
                    $info = $this->subscriptionInfo;
                    $daysLeft = $info['days_remaining'];
                    $isExpiringSoon = $info['is_expiring_soon'];
                    $isExpired = $info['is_expired'];
                    $totalSubs = $info['total_subscriptions'];
                @endphp
                
                @if($daysLeft > 0)
                    
                    <div class="mt-6 p-4 {{ $isExpired ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' : ($isExpiringSoon ? 'bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800' : 'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800') }} rounded-lg">
                        @if($isExpired)
                            <div class="text-red-800 dark:text-red-200">
                                <div class="font-medium mb-1">🚨 {{ __('messages.subscription_expired') }}</div>
                                <div class="text-sm">
                                    {{ __('messages.subscription_has_expired') }}
                                </div>
                            </div>
                        @elseif($isExpiringSoon)
                            <div class="text-yellow-800 dark:text-yellow-200">
                                <div class="font-medium mb-1">� {{ __('messages.subscription_expiring_soon') }}</div>
                                <div class="text-sm">
                                    @if($daysLeft == 0)
                                        {{ __('messages.subscription_expires_today') }}
                                    @else
                                        {{ __('messages.subscription_expires_in_days', ['days' => $daysLeft]) }}
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-blue-800 dark:text-blue-200">
                                <div class="font-medium mb-1">✨ {{ __('messages.subscription_active') }}</div>
                                <div class="text-sm">
                                    {{ __('messages.subscription_valid_for_days', ['days' => $daysLeft]) }}
                                    @if($totalSubs > 1)
                                        <br><span class="text-xs opacity-75">📅 Includes {{ $totalSubs }} subscription periods</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                
                <div class="mt-6 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('messages.subscription_pricing_note') }}
                </div>
            </div>
        </div>
    @else
        <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 text-center">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ __('messages.no_active_subscription') }}</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('messages.subscribe_to_unlock_features') }}</p>
            <a href="{{ route('subscription.pricing') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                {{ __('messages.view_plans') }}
            </a>
        </div>
    @endif
</div>