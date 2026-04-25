<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'image_path',
        'user_id',
        'sort_order',
    ];

    /**
     * Get the user who uploaded the gallery item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the image URL used by the public gallery.
     */
    public function getDisplayImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
                return $this->image_path;
            }

            return Storage::disk('public')->exists($this->image_path)
                ? Storage::url($this->image_path)
                : ($this->image_url ?: null);
        }

        return $this->image_url;
    }
}
