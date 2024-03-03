<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Filament\Pages\Album;
use App\Models\Album as ModelsAlbum;
use App\Models\Photo;
use App\Policies\AlbumPolicy;
use App\Policies\PhotoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Photo::class => PhotoPolicy::class,
        ModelsAlbum::class => AlbumPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}