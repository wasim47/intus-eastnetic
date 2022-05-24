<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\LinkRepositoryInterface;
use App\Repositories\LinkRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LinkRepositoryInterface::class, LinkRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
