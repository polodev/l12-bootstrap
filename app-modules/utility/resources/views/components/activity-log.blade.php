@props(['model'])

@php 
    $activities = $model->activities()->with('causer')->latest()->take(20)->get(); 
@endphp

@if($activities->count() > 0)
    <div class="space-y-3">
        @foreach ($activities as $activity)
            @php
                $properties = $activity->properties->toArray();
                $old_properties = $properties['old'] ?? [];
                $new_properties = $properties['attributes'] ?? [];
                $custom_properties = (!$old_properties && !$new_properties) ? $properties : null;
                
                $title = $activity->description;
                $title .= ' • ' . $activity->created_at->format('M j, Y \a\t g:i A');
                $title .= ' (' . $activity->created_at->diffForHumans() . ')';
                if ($activity->causer) {
                    $title .= ' • by ' . $activity->causer->name;
                }
            @endphp

            <x-utility::collapsible-card 
                :title="$title"
                :collapsed="true"
                headerClass="bg-blue-500 text-white hover:bg-blue-600"
                cardClass="border border-gray-200 dark:border-gray-600"
                contentClass="bg-gray-50 dark:bg-gray-700"
            >
                @if ($activity->causer)
                    <div class="mb-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-md">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            <span class="font-medium">Changed by:</span> 
                            {{ $activity->causer->name }} (ID: {{ $activity->causer->id }})
                        </p>
                    </div>
                @endif

                @if($old_properties || $new_properties)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Column
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Old Value
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        New Value
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach ($new_properties as $key => $new_value)
                                    @continue($key == 'updated_at')
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ ucwords(str_replace('_', ' ', $key)) }}
                                        </td>
                                        <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-300 max-w-xs break-words">
                                            @if (isset($old_properties[$key]))
                                                @if (in_array($key, ['created_at', 'updated_at', 'payment_date']) && $old_properties[$key])
                                                    <span class="text-xs">
                                                        {{ \Carbon\Carbon::parse($old_properties[$key])->format('M j, Y g:i A') }}
                                                    </span>
                                                @elseif (is_numeric($old_properties[$key]) && str_contains($key, 'amount'))
                                                    <span class="font-mono text-red-600 dark:text-red-400">
                                                        ৳{{ number_format($old_properties[$key], 2) }}
                                                    </span>
                                                @else
                                                    <span class="text-red-600 dark:text-red-400">
                                                        {{ is_array($old_properties[$key]) ? json_encode($old_properties[$key]) : $old_properties[$key] }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-400 italic">—</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-300 max-w-xs break-words">
                                            @if (in_array($key, ['created_at', 'updated_at', 'payment_date']) && $new_value)
                                                <span class="text-xs">
                                                    {{ \Carbon\Carbon::parse($new_value)->format('M j, Y g:i A') }}
                                                </span>
                                            @elseif (is_numeric($new_value) && str_contains($key, 'amount'))
                                                <span class="font-mono text-green-600 dark:text-green-400">
                                                    ৳{{ number_format($new_value, 2) }}
                                                </span>
                                            @else
                                                <span class="text-green-600 dark:text-green-400">
                                                    {{ is_array($new_value) ? json_encode($new_value) : $new_value }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if($custom_properties)
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Custom Properties</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Property
                                        </th>
                                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Value
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach ($custom_properties as $key => $value)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-3 py-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </td>
                                            <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-300 max-w-xs break-words">
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </x-utility::collapsible-card>
        @endforeach
    </div>
@else
    <div class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No activity logs</h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No changes have been recorded for this item yet.</p>
    </div>
@endif