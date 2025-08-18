<?php

namespace App\Helpers;

use Carbon\Carbon;

class Helpers
{
    use \App\Helpers\Traits\RoleHelpers;
    use \Modules\Payment\Libraries\PaymentHelpersTrait;
    
    /**
     * Format date with optional time, day, and diff for humans
     */
    public static function getDateAndDiff($date, $is_day_return = true, $is_diff_return = false, $is_time_return = false)
    {
        if (!$date) {
            return '';
        }
        
        $parsed_date = Carbon::create($date);
        $date = $parsed_date->toFormattedDateString();
        $time = $parsed_date->format('g:i A');
        $diff = $parsed_date->diffForHumans();
        $day = $parsed_date->shortEnglishDayOfWeek;
        $final_output = "{$date}";
        
        if ($is_time_return) {
            $final_output .= " {$time}";
        }
        
        if ($is_day_return) {
            $final_output .= ", {$day}";
        }
        
        if ($is_diff_return) {
            $final_output .= " ({$diff})";
        }
        
        return $final_output;
    }

    /**
     * Format date for DataTables with proper HTML structure
     */
    public static function getFormattedDateForDataTable($date, $show_time = false)
    {
        if (!$date) {
            return '<span class="text-gray-500 dark:text-gray-400 text-sm">N/A</span>';
        }

        $parsed_date = Carbon::create($date);
        $formatted_date = $parsed_date->format('M d, Y');
        $diff = $parsed_date->diffForHumans();
        
        if ($show_time) {
            $formatted_date .= ' ' . $parsed_date->format('g:i A');
        }

        return '<div class="text-sm">
                    <div class="text-gray-900 dark:text-gray-100">' . $formatted_date . '</div>
                    <div class="text-gray-500 dark:text-gray-400 text-xs">' . $diff . '</div>
                </div>';
    }

    /**
     * Render markdown content with rich typography styling
     * Uses the same approach as blog and documentation content
     * 
     * @param string $content The markdown content to render
     * @param string $size Size variant: 'sm', 'base', 'lg' (default: 'sm')
     * @param string $accent_color Accent color for links/quotes: 'blue', 'green', 'eco-green' (default: 'blue')
     * @param array $additional_classes Additional CSS classes to add
     * @return string Rendered HTML with prose styling
     */
    public static function renderMarkdown(string $content, string $size = 'sm', string $accent_color = 'blue', array $additional_classes = []): string
    {
        if (empty(trim($content))) {
            return '';
        }

        // Convert markdown to HTML
        $html = \Illuminate\Support\Str::markdown($content);

        // Build prose classes based on size
        $prose_classes = match($size) {
            'base' => 'prose prose-base',
            'lg' => 'prose prose-lg',
            'xl' => 'prose prose-xl',
            default => 'prose prose-sm'
        };

        // Build accent color classes
        $accent_classes = match($accent_color) {
            'green' => 'prose-a:text-green-600 dark:prose-a:text-green-400 prose-blockquote:border-green-500 prose-blockquote:bg-green-50 dark:prose-blockquote:bg-green-900/20',
            'eco-green' => 'prose-a:text-eco-green dark:prose-a:text-eco-green prose-blockquote:border-eco-green prose-blockquote:bg-eco-green/5 dark:prose-blockquote:bg-eco-green/10',
            'red' => 'prose-a:text-red-600 dark:prose-a:text-red-400 prose-blockquote:border-red-500 prose-blockquote:bg-red-50 dark:prose-blockquote:bg-red-900/20',
            default => 'prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/20'
        };

        // Combine all classes
        $all_classes = [
            $prose_classes,
            'max-w-none dark:prose-invert',
            'prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100',
            'prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed',
            'prose-li:text-gray-700 dark:prose-li:text-gray-300',
            'prose-strong:text-gray-900 dark:prose-strong:text-gray-100',
            'prose-code:text-red-600 dark:prose-code:text-red-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm',
            'prose-pre:bg-gray-50 dark:prose-pre:bg-gray-900 prose-pre:border prose-pre:border-gray-200 dark:prose-pre:border-gray-700',
            'prose-blockquote:border-l-4 prose-blockquote:pl-6 prose-blockquote:py-4 prose-blockquote:rounded-r',
            $accent_classes,
            'prose-a:no-underline hover:prose-a:underline',
            'prose-img:rounded-lg prose-img:shadow-lg',
            ...$additional_classes
        ];

        $class_string = implode(' ', $all_classes);

        return "<div class=\"{$class_string}\">{$html}</div>";
    }

    /**
     * Render markdown content with compact styling (for lists, small content)
     * Simplified version for support tickets, comments, etc.
     * 
     * @param string $content The markdown content to render
     * @param array $additional_classes Additional CSS classes to add
     * @return string Rendered HTML with compact prose styling
     */
    public static function renderMarkdownCompact(string $content, array $additional_classes = []): string
    {
        if (empty(trim($content))) {
            return '';
        }

        // Convert markdown to HTML
        $html = \Illuminate\Support\Str::markdown($content);

        // Compact prose classes for support tickets, comments, etc.
        $all_classes = [
            'prose prose-sm max-w-none dark:prose-invert',
            'prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:my-2',
            'prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-li:my-0',
            'prose-ul:my-2 prose-ol:my-2',
            'prose-strong:text-gray-900 dark:prose-strong:text-gray-100',
            'prose-code:text-red-600 dark:prose-code:text-red-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-1 prose-code:py-0.5 prose-code:rounded prose-code:text-xs',
            'prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline',
            ...$additional_classes
        ];

        $class_string = implode(' ', $all_classes);

        return "<div class=\"{$class_string}\">{$html}</div>";
    }
}