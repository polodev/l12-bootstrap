<div class="space-y-1">
    <div class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $coupon->code }}</div>
    <div class="font-medium text-gray-700 dark:text-gray-300">{{ $coupon->name }}</div>
    @if($coupon->description)
    <div class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ Str::limit($coupon->description, 80) }}</div>
    @endif
</div>