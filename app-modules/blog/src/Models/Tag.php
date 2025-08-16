<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'english_name',
        'slug',
        'name',
        'type',
        'order_column',
    ];

    public $translatable = ['name'];

    protected $casts = [
        'order_column' => 'integer',
    ];

    /**
     * Generate slug from english_name
     */
    public function generateSlug(): self
    {
        if (empty($this->english_name)) {
            return $this;
        }

        $slug = Str::slug($this->english_name);
        
        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $this->slug = $slug;

        return $this;
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->generateSlug();
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('english_name')) {
                $tag->generateSlug();
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Find tag by slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Find tag by slug or fail
     */
    public static function findBySlugOrFail(string $slug): self
    {
        return static::where('slug', $slug)->firstOrFail();
    }

    /**
     * Get all blogs that have this tag
     */
    public function blogs(): MorphToMany
    {
        return $this->morphedByMany(Blog::class, 'taggable');
    }
}