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
        if (empty($this->main_image)) {
            return 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=1200&q=80';
        }

        if (Str::startsWith($this->main_image, ['http://', 'https://'])) {
            return $this->main_image;
        }

        return asset($this->main_image);
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

            return asset($img);
        }, $this->gallery_images);
    }
}
