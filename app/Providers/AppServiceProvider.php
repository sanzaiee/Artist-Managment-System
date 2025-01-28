<?php

namespace App\Providers;

use App\Livewire\Auth\Registration;
use App\Models\Artist;
use App\Models\Music;
use App\Models\User;
use App\Policies\ArtistPolicy;
use App\Policies\MusicPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('registration', Registration::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Artist::class, ArtistPolicy::class);
        Gate::policy(Music::class, MusicPolicy::class);
    }
}
