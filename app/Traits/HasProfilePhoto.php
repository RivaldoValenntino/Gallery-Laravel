<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasProfilePhoto
{
    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->avatar
            ? Storage::disk($this->profilePhotoDisk())->url($this->avatar)
            : $this->defaultProfilePhotoUrl();
    }

    public function updateProfilePhoto(?string $photo): void
    {
        tap($this->avatar, function ($previous) use ($photo) {
            $this->forceFill([
                'avatar' => $photo,
            ])->save();

            if ($previous && !$photo) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    protected function defaultProfilePhotoUrl(): string
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function profilePhotoDisk(): string
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('your-config.profile_photo_disk', 'public');
    }

    public function profilePhotoDirectory(): string
    {
        return config('your-config.profile_photo_directory', 'profile-photos');
    }
}