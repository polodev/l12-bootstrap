<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'state_province',
        'latitude',
        'longitude',
        'timezone',
        'population',
        'is_active',
        'is_capital',
        'is_popular',
        'position'
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6',
        'population' => 'integer',
        'is_active' => 'boolean',
        'is_capital' => 'boolean',
        'is_popular' => 'boolean',
        'position' => 'integer',
    ];

    /**
     * Get the country that owns this city.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }


    /**
     * Scope for active cities.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for popular cities.
     */
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    /**
     * Scope for capital cities.
     */
    public function scopeCapital($query)
    {
        return $query->where('is_capital', true);
    }

    /**
     * Scope for ordered cities.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('name');
    }

    /**
     * Scope for searching cities by name.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhereHas('country', function ($countryQuery) use ($term) {
                  $countryQuery->where('name', 'LIKE', "%{$term}%");
              });
        });
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $color = $this->is_active 
            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
            : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';

        $status = $this->is_active ? 'Active' : 'Inactive';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . $status . '</span>';
    }

    /**
     * Get popular badge.
     */
    public function getPopularBadgeAttribute()
    {
        if (!$this->is_popular) {
            return '';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">Popular</span>';
    }

    /**
     * Get capital badge.
     */
    public function getCapitalBadgeAttribute()
    {
        if (!$this->is_capital) {
            return '';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">Capital</span>';
    }


    /**
     * Get full name with country.
     */
    public function getFullNameAttribute()
    {
        return $this->name . ', ' . $this->country->name;
    }
}