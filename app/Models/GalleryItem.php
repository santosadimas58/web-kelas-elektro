<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

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
            return '/storage/'.$this->image_path;
        }

        return $this->image_url;
    }
}
