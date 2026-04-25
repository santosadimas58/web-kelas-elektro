<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nim',
        'prodi',
        'angkatan',
        'email',
        'photo_path',
        'study_focus',
        'bio',
        'sort_order',
    ];

    /**
     * The model attribute casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'angkatan' => 'integer',
    ];

    public function getNimAttribute($value): ?string
    {
        return $value ?: $this->legacyProfileData()['nim'];
    }

    public function getProdiAttribute($value): ?string
    {
        if ($value) {
            return $value;
        }

        return $this->legacyProfileData()['prodi'] ?: $this->getRawOriginal('study_focus');
    }

    public function getAngkatanAttribute($value): ?int
    {
        if ($value !== null) {
            return (int) $value;
        }

        $legacyAngkatan = $this->legacyProfileData()['angkatan'];

        return $legacyAngkatan !== null ? (int) $legacyAngkatan : null;
    }

    public function getEmailAttribute($value): ?string
    {
        return $value ?: $this->legacyProfileData()['email'];
    }

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

    /**
     * Resolve the best image URL for the student profile photo.
     */
    protected function photoImageUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if ($this->photo_path) {
                if (Str::startsWith($this->photo_path, ['http://', 'https://'])) {
                    return $this->photo_path;
                }

                return Storage::disk('public')->exists($this->photo_path)
                    ? Storage::url($this->photo_path)
                    : null;
            }

            $legacyPhotoUrl = $this->getRawOriginal('photo_url');

            return $legacyPhotoUrl ?: null;
        });
    }

    /**
     * Extract profile fields from the legacy bio text when the new columns do not exist yet.
     *
     * @return array{nim: ?string, prodi: ?string, angkatan: ?string, email: ?string}
     */
    protected function legacyProfileData(): array
    {
        $bio = (string) ($this->attributes['bio'] ?? '');
        $studyFocus = $this->attributes['study_focus'] ?? null;

        preg_match('/^(.*?) angkatan \d{4}/', $bio, $prodiMatches);
        preg_match('/angkatan (\d{4})/', $bio, $angkatanMatches);
        preg_match('/NIM\s+([^.]+)/', $bio, $nimMatches);
        preg_match('/Kontak:\s*([^\s.]+@[^\s.]+\.[^\s.]+)/', $bio, $emailMatches);

        return [
            'nim' => isset($nimMatches[1]) ? trim($nimMatches[1]) : null,
            'prodi' => isset($prodiMatches[1]) ? trim($prodiMatches[1]) : $studyFocus,
            'angkatan' => isset($angkatanMatches[1]) ? trim($angkatanMatches[1]) : null,
            'email' => isset($emailMatches[1]) ? trim($emailMatches[1]) : null,
        ];
    }
}
