<?php

namespace Modules\Page\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use App\Models\User;

class Page extends Model
{
    use HasFactory, HasSlug, HasTranslations;

    protected $fillable = [
        'english_title',
        'slug',
        'title',
        'content',
        'template',
        'meta_title',
        'meta_description',
        'keywords',
        'status',
        'published_at',
        'position',
        'user_id'
    ];

    protected $translatable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'keywords'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'position' => 'integer',
        'title' => 'array',
        'content' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'keywords' => 'array',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('english_title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Scope for published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for draft pages.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'published' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
        ];

        $color = $colors[$this->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100';

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color . '">' 
               . ucfirst($this->status ?? 'N/A') . '</span>';
    }

    /**
     * Get available statuses.
     */
    public static function getAvailableStatuses(): array
    {
        return [
            'draft' => 'Draft',
            'published' => 'Published',
        ];
    }

    /**
     * Get available templates from templates directory.
     */
    public static function getAvailableTemplates(): array
    {
        $templatesPath = resource_path('views/templates');
        $templates = ['default' => 'Default (Content Only)'];
        
        if (is_dir($templatesPath)) {
            $files = glob($templatesPath . '/*.blade.php');
            foreach ($files as $file) {
                $templateName = basename($file, '.blade.php');
                $displayName = ucwords(str_replace(['-', '_'], ' ', $templateName));
                $templates[$templateName] = $displayName;
            }
        }
        
        return $templates;
    }

    /**
     * Check if page is published and live.
     */
    public function isLive(): bool
    {
        return $this->status === 'published' 
               && $this->published_at !== null 
               && $this->published_at <= now();
    }

    /**
     * Get the user that created this page.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if template file exists.
     */
    public function hasTemplate(): bool
    {
        if (!$this->template || $this->template === 'default') {
            return false;
        }
        
        return view()->exists("templates.{$this->template}");
    }

    /**
     * Get template view name.
     */
    public function getTemplateView(): string
    {
        if ($this->hasTemplate()) {
            return "templates.{$this->template}";
        }
        
        return 'pages.default';
    }
}