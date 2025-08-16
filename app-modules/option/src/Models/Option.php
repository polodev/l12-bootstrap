<?php

namespace Modules\Option\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Option extends Model
{
    protected $fillable = [
        'option_name',
        'batch_name',
        'option_value',
        'option_type',
        'description',
        'position',
        'is_autoload',
        'is_system'
    ];

    protected $casts = [
        'is_autoload' => 'boolean',
        'is_system' => 'boolean',
    ];

    // Cache duration in minutes
    const CACHE_DURATION = 60;

    /**
     * Get an option value by name
     */
    public static function get(string $optionName, $default = null)
    {
        $cacheKey = "option_{$optionName}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION * 60, function () use ($optionName, $default) {
            $option = self::where('option_name', $optionName)->first();
            
            if (!$option) {
                return $default;
            }
            
            return self::castValue($option->option_value, $option->option_type);
        });
    }

    /**
     * Set an option value
     */
    public static function set(string $optionName, $value, string $type = 'string', string $description = null, bool $isAutoload = false, string $batchName = null, int $position = 0): bool
    {
        $optionValue = self::prepareValue($value, $type);
        
        $option = self::updateOrCreate(
            ['option_name' => $optionName],
            [
                'batch_name' => $batchName,
                'option_value' => $optionValue,
                'option_type' => $type,
                'description' => $description,
                'position' => $position,
                'is_autoload' => $isAutoload
            ]
        );

        // Clear cache
        Cache::forget("option_{$optionName}");
        
        return $option->wasRecentlyCreated || $option->wasChanged();
    }

    /**
     * Delete an option by name
     */
    public static function remove(string $optionName): bool
    {
        $deleted = self::where('option_name', $optionName)->delete();
        
        // Clear cache
        Cache::forget("option_{$optionName}");
        
        return $deleted > 0;
    }

    /**
     * Check if an option exists
     */
    public static function exists(string $optionName): bool
    {
        return self::where('option_name', $optionName)->exists();
    }

    /**
     * Get multiple options at once
     */
    public static function getMultiple(array $optionNames): array
    {
        $results = [];
        
        foreach ($optionNames as $name) {
            $results[$name] = self::get($name);
        }
        
        return $results;
    }

    /**
     * Get all autoload options (for performance optimization)
     */
    public static function getAutoloadOptions(): array
    {
        return Cache::remember('autoload_options', self::CACHE_DURATION * 60, function () {
            $options = self::where('is_autoload', true)->get();
            $result = [];
            
            foreach ($options as $option) {
                $result[$option->option_name] = self::castValue($option->option_value, $option->option_type);
            }
            
            return $result;
        });
    }

    /**
     * Get options by batch name
     */
    public static function getBatch(string $batchName): array
    {
        $cacheKey = "batch_{$batchName}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION * 60, function () use ($batchName) {
            $options = self::where('batch_name', $batchName)->orderBy('position')->get();
            $result = [];
            
            foreach ($options as $option) {
                $result[$option->option_name] = self::castValue($option->option_value, $option->option_type);
            }
            
            return $result;
        });
    }

    /**
     * Set multiple options for a batch
     */
    public static function setBatch(string $batchName, array $options): bool
    {
        $success = true;
        $position = 0;
        
        foreach ($options as $optionName => $config) {
            $value = $config['value'] ?? $config;
            $type = $config['type'] ?? 'string';
            $description = $config['description'] ?? null;
            $isAutoload = $config['is_autoload'] ?? false;
            $itemPosition = $config['position'] ?? $position;
            
            $result = self::set($optionName, $value, $type, $description, $isAutoload, $batchName, $itemPosition);
            if (!$result) {
                $success = false;
            }
            $position++;
        }
        
        // Clear batch cache
        Cache::forget("batch_{$batchName}");
        
        return $success;
    }

    /**
     * Delete all options in a batch
     */
    public static function deleteBatch(string $batchName): bool
    {
        $options = self::where('batch_name', $batchName)->get();
        
        foreach ($options as $option) {
            Cache::forget("option_{$option->option_name}");
        }
        
        $deleted = self::where('batch_name', $batchName)->delete();
        
        // Clear batch cache
        Cache::forget("batch_{$batchName}");
        Cache::forget('autoload_options');
        
        return $deleted > 0;
    }

    /**
     * Get all available batch names
     */
    public static function getBatchNames(): array
    {
        return self::whereNotNull('batch_name')
                  ->distinct()
                  ->pluck('batch_name')
                  ->filter()
                  ->values()
                  ->toArray();
    }

    /**
     * Clear all option caches
     */
    public static function clearCache(): void
    {
        // This would require a more sophisticated cache tagging system
        // For now, we'll clear specific known cache keys
        Cache::forget('autoload_options');
        
        // Clear individual option caches - this is not perfect but works for most cases
        $options = self::pluck('option_name');
        foreach ($options as $optionName) {
            Cache::forget("option_{$optionName}");
        }
        
        // Clear batch caches
        $batchNames = self::getBatchNames();
        foreach ($batchNames as $batchName) {
            Cache::forget("batch_{$batchName}");
        }
    }

    /**
     * Prepare value for storage based on type
     */
    protected static function prepareValue($value, string $type): string
    {
        switch ($type) {
            case 'json':
            case 'array':
                return json_encode($value);
            case 'boolean':
                return $value ? '1' : '0';
            case 'integer':
                return (string) intval($value);
            case 'float':
                return (string) floatval($value);
            default:
                return (string) $value;
        }
    }

    /**
     * Cast stored value to appropriate type
     */
    protected static function castValue(string $value, string $type)
    {
        switch ($type) {
            case 'json':
                return json_decode($value, true);
            case 'array':
                $decoded = json_decode($value, true);
                return is_array($decoded) ? $decoded : [];
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            default:
                return $value;
        }
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when option is updated or deleted
        static::saved(function ($option) {
            Cache::forget("option_{$option->option_name}");
            Cache::forget('autoload_options');
            if ($option->batch_name) {
                Cache::forget("batch_{$option->batch_name}");
            }
        });

        static::deleted(function ($option) {
            Cache::forget("option_{$option->option_name}");
            Cache::forget('autoload_options');
            if ($option->batch_name) {
                Cache::forget("batch_{$option->batch_name}");
            }
        });
    }

    /**
     * Get formatted option value for display
     */
    public function getFormattedValueAttribute(): string
    {
        $value = self::castValue($this->option_value, $this->option_type);
        
        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_PRETTY_PRINT);
        }
        
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        
        return (string) $value;
    }

    /**
     * Get type badge for display
     */
    public function getTypeBadgeAttribute(): string
    {
        $colors = [
            'string' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
            'json' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-300',
            'array' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-300',
            'boolean' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-300',
            'integer' => 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-300',
            'float' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-300',
        ];

        $colorClass = $colors[$this->option_type] ?? $colors['string'];
        
        return "<span class=\"inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$colorClass}\">{$this->option_type}</span>";
    }

    /**
     * Get autoload badge for display
     */
    public function getAutoloadBadgeAttribute(): string
    {
        if ($this->is_autoload) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-300">Autoload</span>';
        }
        
        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300">Manual</span>';
    }

    /**
     * Get system badge for display
     */
    public function getSystemBadgeAttribute(): string
    {
        if ($this->is_system) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-300">System</span>';
        }
        
        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-300">User</span>';
    }
}