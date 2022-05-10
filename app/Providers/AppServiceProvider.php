<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\ConnectionResolverInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->enableDBLogging();
    }

    private function enableDBLogging()
    {
        if ($this->app['config']['app.debug']) {
            $db = $this->app->make(ConnectionResolverInterface::class);

            // Enable query logging
            $db->enableQueryLog();

            $db->listen(function (QueryExecuted $event) {
                Log::info($event->sql);
                Log::info('["' . implode('","', $event->bindings) . '"]');
                Log::info('Query take ' . $event->time);
            });
        }
    }
}
