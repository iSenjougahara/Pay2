<?php

namespace App\Providers;

use App\Models\Conta;
use App\Models\User;
use App\Repository\UserRepository;
use App\Repository\IUserRepository;
use App\Repository\ContaRepository;
use App\Repository\IContaRepository;
use Illuminate\Support\ServiceProvider;
//LEMBRA DE IMPORTAR AQUI TAMBEM KCT
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
        $this->app->bind(IContaRepository::class, ContaRepository::class);
    }
}
