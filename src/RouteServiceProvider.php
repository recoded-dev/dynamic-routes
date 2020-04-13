<?php

namespace Recoded\DynamicRoutes;

use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Recoded\DynamicRoutes\Concerns\BuildsRouteCachePath;
use Recoded\DynamicRoutes\Concerns\HasRouteKey;
use Recoded\DynamicRoutes\Concerns\RegistersRouterMacro;
use Recoded\DynamicRoutes\Console\Commands\RouteCacheCommand;
use Recoded\DynamicRoutes\Console\Commands\RouteClearCommand;
use Recoded\DynamicRoutes\Contracts\DynamicRouteResolver;

class RouteServiceProvider extends ServiceProvider
{
    use BuildsRouteCachePath;
    use HasRouteKey;
    use RegistersRouterMacro;

    const ROUTE_CACHE_PATH_ENV = 'APP_ROUTES_CACHE';

    public function boot(Application $app): void
    {
        $this->registerRouterMacro();

        $this->app->extend('command.route.cache', function (Command $old, Application $app) {
            return new RouteCacheCommand($app['files']);
        });

        $this->app->extend('command.route.clear', function (Command $old, Application $app) {
            return new RouteClearCommand($app['files']);
        });

        static::updateRouteCachePath($app);

        $this->publishes([
            __DIR__ . '/../config/dynamic-routes.php' => config_path('dynamic-routes.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->app->singleton(DynamicRouteResolver::class, function (Application $app) {
            return $app->make(
                $app['config']['dynamic-routes.resolver'],
            );
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/dynamic-routes.php', 'dynamic-routes');
    }

    public static function resolve(): string
    {
        /** @var \Recoded\DynamicRoutes\Contracts\DynamicRouteResolver $resolver */
        $resolver = app(DynamicRouteResolver::class);

        return $resolver->resolve();
    }
}
