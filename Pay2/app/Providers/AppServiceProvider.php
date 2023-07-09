<?php

namespace App\Providers;

use App\Models\User;
use App\Repository\UserRepository;
use App\Repository\IUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }
}
