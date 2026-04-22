<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'bio',
        'photo_url',
        'study_focus',
        'sort_order',
    ];

    /**
     * Get student initials for placeholder avatar.
     */
    protected function initials(): Attribute
    {
        return Attribute::get(function (): string {
            return collect(explode(' ', (string) $this->name))
                ->filter()
                ->take(2)
                ->map(fn (string $part): string => strtoupper(substr($part, 0, 1)))
                ->implode('');
        });
    }
}
