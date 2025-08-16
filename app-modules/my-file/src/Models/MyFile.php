<?php

namespace Modules\MyFile\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MyFile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'extension',
        'mime_type',
        'size',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('my_file')
            ->singleFile()
            ->useDisk(env('MEDIA_DISK', 'public'));
    }

    /**
     * Register media conversions
     */
    public function registerMediaConversions(Media $media = null): void
    {
        // No conversions needed - using original files only
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('my_file');
        if (!$media) {
            return null;
        }
        
        // Always use the public URL for clean URLs
        // This assumes your S3 bucket allows public read access
        return $this->getFirstMediaUrl('my_file');
    }

    /**
     * Get a temporary signed URL (use this when you need secure access)
     */
    public function getSecureFileUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('my_file');
        if (!$media) {
            return null;
        }
        
        // For S3 or remote storage, generate a temporary URL if the disk is private
        if ($media->disk === 's3-media' || $media->disk === 's3') {
            try {
                // Generate a temporary URL valid for 1 hour
                return \Storage::disk($media->disk)->temporaryUrl(
                    $media->getPathRelativeToRoot(),
                    now()->addHour()
                );
            } catch (\Exception $e) {
                \Log::error('Failed to generate temporary URL for media', [
                    'media_id' => $media->id,
                    'disk' => $media->disk,
                    'error' => $e->getMessage()
                ]);
                return null;
            }
        }
        
        // For local or public storage, use the regular URL
        return $this->getFirstMediaUrl('my_file');
    }



    /**
     * Get the file name
     */
    public function getFileNameAttribute(): ?string
    {
        $media = $this->getFirstMedia('my_file');
        return $media ? $media->name : null;
    }

    /**
     * Get the file size in human readable format
     */
    public function getFileSizeAttribute(): ?string
    {
        $media = $this->getFirstMedia('my_file');
        return $media ? $this->formatBytes($media->size) : null;
    }

    /**
     * Get the file extension
     */
    public function getFileExtensionAttribute(): ?string
    {
        $media = $this->getFirstMedia('my_file');
        return $media ? pathinfo($media->file_name, PATHINFO_EXTENSION) : null;
    }

    /**
     * Check if file exists
     */
    public function hasFile(): bool
    {
        return $this->getFirstMedia('my_file') !== null;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes(int $size, int $precision = 2): string
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

    /**
     * Scope for active files
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for files with media
     */
    public function scopeWithFiles($query)
    {
        return $query->whereHas('media');
    }
}