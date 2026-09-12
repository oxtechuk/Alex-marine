<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MaintenanceProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'title_ar',
        'title_en',
        'slug',
        'client_name',
        'vessel_type',
        'location_ar',
        'location_en',
        'duration',
        'short_desc_ar',
        'short_desc_en',
        'description_ar',
        'description_en',
        'specifications',
        'main_image',
        'video_url',
        'gallery_images',
        'before_image',
        'after_image',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'specifications' => 'array',
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get localized title.
     */
    public function getTitleAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->title_en)) {
            return $this->title_en;
        }

        return $this->title_ar ?? '';
    }

    /**
     * Get localized short description.
     */
    public function getShortDescAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->short_desc_en)) {
            return $this->short_desc_en;
        }

        return $this->short_desc_ar ?? '';
    }

    /**
     * Get localized full description.
     */
    public function getDescriptionAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->description_en)) {
            return $this->description_en;
        }

        return $this->description_ar ?? '';
    }

    /**
     * Get localized location.
     */
    public function getLocationAttribute(): string
    {
        if (app()->getLocale() === 'en' && ! empty($this->location_en)) {
            return $this->location_en;
        }

        return $this->location_ar ?? '';
    }

    /**
     * Get full image URL helper
     */
    public function getMainImageUrlAttribute(): string
    {
        if (! empty($this->main_image)) {
            if (Str::startsWith($this->main_image, ['http://', 'https://'])) {
                return $this->main_image;
            }

            return asset(ltrim($this->main_image, '/'));
        }

        if (! empty($this->after_image)) {
            return $this->after_image_url;
        }

        if (! empty($this->before_image)) {
            return $this->before_image_url;
        }

        return 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=1200&q=80';
    }

    /**
     * Get before maintenance image URL
     */
    public function getBeforeImageUrlAttribute(): string
    {
        if (! empty($this->before_image)) {
            if (Str::startsWith($this->before_image, ['http://', 'https://'])) {
                return $this->before_image;
            }

            return asset(ltrim($this->before_image, '/'));
        }

        return 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=1200&q=80';
    }

    /**
     * Get after maintenance image URL
     */
    public function getAfterImageUrlAttribute(): string
    {
        if (! empty($this->after_image)) {
            if (Str::startsWith($this->after_image, ['http://', 'https://'])) {
                return $this->after_image;
            }

            return asset(ltrim($this->after_image, '/'));
        }

        return 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?auto=format&fit=crop&w=1200&q=80';
    }

    /**
     * Check if project has custom before and after images
     */
    public function getHasBeforeAfterAttribute(): bool
    {
        return ! empty($this->before_image) && ! empty($this->after_image);
    }

    /**
     * Get all gallery image URLs
     */
    public function getGalleryImageUrlsAttribute(): array
    {
        if (empty($this->gallery_images) || ! is_array($this->gallery_images)) {
            return [];
        }

        return array_map(function ($img) {
            if (Str::startsWith($img, ['http://', 'https://'])) {
                return $img;
            }

            return asset(ltrim($img, '/'));
        }, $this->gallery_images);
    }
}
