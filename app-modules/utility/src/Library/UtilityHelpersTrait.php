<?php

namespace Modules\Utility\Library;

use Carbon\Carbon;

trait UtilityHelpersTrait
{
    /**
     * Format date with optional time, day, and diff for humans
     *
     * @param mixed $date
     * @param bool $is_day_return
     * @param bool $is_diff_return
     * @param bool $is_time_return
     * @return string
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
     *
     * @param mixed $date
     * @param bool $show_time
     * @return string
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
}