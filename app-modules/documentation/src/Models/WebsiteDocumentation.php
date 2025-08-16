<?php

namespace Modules\Documentation\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\User;

class WebsiteDocumentation extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'section',
        'slug',
        'title',
        'content',
        'difficulty',
        'position',
        'is_published',
        'user_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'position' => 'integer',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope for published documentation.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for specific sections.
     */
    public function scopeSection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Get the formatted content as HTML.
     */
    public function getFormattedContentAttribute()
    {
        // Convert markdown to HTML if needed
        return $this->content;
    }

    /**
     * Get difficulty badge color.
     */
    public function getDifficultyBadgeAttribute()
    {
        $colors = [
            'beginner' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'intermediate' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'advanced' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
        ];

        $color = $colors[$this->difficulty] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . ucfirst($this->difficulty ?? 'N/A') . '</span>';
    }

    /**
     * Get available sections.
     */
    public static function getAvailableSections(): array
    {
        return [
            'getting-started' => 'Getting Started',
            'installation' => 'Installation',
            'configuration' => 'Configuration',
            'features' => 'Features',
            'api' => 'API Documentation',
            'troubleshooting' => 'Troubleshooting',
            'advanced' => 'Advanced Topics',
            'changelog' => 'Changelog',
        ];
    }

    /**
     * Get available difficulties.
     */
    public static function getAvailableDifficulties(): array
    {
        return [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
        ];
    }

    /**
     * Get the user that created this documentation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}