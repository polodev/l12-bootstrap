<div class="space-y-1">
    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $plan->name }}</div>
    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->duration_text }}</div>
    @if($plan->description)
    <div class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ Str::limit($plan->description, 60) }}</div>
    @endif
</div>