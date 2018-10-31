<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use RestCord\DiscordClient;

class RestCordServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DiscordClient::class, function ($app) {
            return new DiscordClient([
                'token'  => config('services.discord.token'),
                'logger' => $app['log']->channel()->getLogger(),
            ]);
        });
    }
}
