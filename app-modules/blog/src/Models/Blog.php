<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\User;

class Blog extends Model implements HasMedia
{
    use HasFactory, HasSlug, HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'english_title',
        'slug',
        'title',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'noindex',
        'nofollow',
        'status',
        'published_at',
        'position',
        'user_id'
    ];

    protected $translatable = [
        'title',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'position' => 'integer',
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
        'title' => 'array',
        'content' => 'array',
        'excerpt' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
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
     * Scope for published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for draft blogs.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope for scheduled blogs.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
                    ->whereNotNull('published_at')
                    ->where('published_at', '>', now());
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
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'published' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
            'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
            'scheduled' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
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
            'scheduled' => 'Scheduled',
        ];
    }

    /**
     * Check if blog is published and live.
     */
    public function isLive(): bool
    {
        return $this->status === 'published' 
               && $this->published_at !== null 
               && $this->published_at <= now();
    }

    /**
     * Get the user that created this blog.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all tags for this blog.
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Attach tags to this blog.
     */
    public function attachTags(array $tags): self
    {
        $tagIds = [];
        
        foreach ($tags as $tag) {
            if (is_string($tag)) {
                // Find by english_name or create new tag
                $tagModel = Tag::where('english_name', $tag)->first();
                if (!$tagModel) {
                    $tagModel = Tag::create([
                        'english_name' => $tag,
                        'name' => ['en' => $tag, 'bn' => $tag] // Default to same for both languages
                    ]);
                }
                $tagIds[] = $tagModel->id;
            } elseif (is_numeric($tag)) {
                $tagIds[] = $tag;
            } elseif ($tag instanceof Tag) {
                $tagIds[] = $tag->id;
            }
        }
        
        $this->tags()->attach($tagIds);
        
        return $this;
    }

    /**
     * Sync tags for this blog.
     */
    public function syncTags(array $tags): self
    {
        $tagIds = [];
        
        foreach ($tags as $tag) {
            if (is_string($tag)) {
                // Find by english_name or create new tag
                $tagModel = Tag::where('english_name', $tag)->first();
                if (!$tagModel) {
                    $tagModel = Tag::create([
                        'english_name' => $tag,
                        'name' => ['en' => $tag, 'bn' => $tag] // Default to same for both languages
                    ]);
                }
                $tagIds[] = $tagModel->id;
            } elseif (is_numeric($tag)) {
                $tagIds[] = $tag;
            } elseif ($tag instanceof Tag) {
                $tagIds[] = $tag->id;
            }
        }
        
        $this->tags()->sync($tagIds);
        
        return $this;
    }

    /**
     * Detach all tags from this blog.
     */
    public function detachTags(): self
    {
        $this->tags()->detach();
        
        return $this;
    }

    /**
     * Get tag names as array.
     */
    public function getTagNamesAttribute(): array
    {
        return $this->tags->pluck('english_name')->toArray();
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')->singleFile();
    }

    /**
     * Get the featured image URL.
     */
    public function getFeaturedImageAttribute(): ?string
    {
        $media = $this->getFirstMedia('featured_image');
        return $media ? $media->getUrl() : null;
    }

    /**
     * Get the featured image media object.
     */
    public function getFeaturedImageMedia(): ?Media
    {
        return $this->getFirstMedia('featured_image');
    }
}