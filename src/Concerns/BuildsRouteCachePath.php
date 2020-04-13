<?php

namespace Recoded\DynamicRoutes\Concerns;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Env;

trait BuildsRouteCachePath
{
    protected static string $oldPath;

    public static function buildNewRouteCachePath(string $old): string
    {
        return preg_replace('/(.*).php/', '$1.' . static::getRouteKey() . '.php', $old);
    }

    protected static function findOldRouteCachePath(Application $application): ?string
    {
        if (!empty(static::$oldPath)) {
            return static::$oldPath;
        }

        if ($application instanceof \Illuminate\Foundation\Application) {
            return static::$oldPath = $application->getCachedRoutesPath();
        }

        return null;
    }

    protected static function setEnv(string $key, $value = null): void
    {
        if (method_exists(Env::class, 'getRepository')) {
            Env::getRepository()->set($key, $value);

            return;
        } elseif (method_exists(Env::class, 'getVariables')) {
            Env::getVariables()->set($key, $value);

            return;
        }

        throw new \RuntimeException('Unable to discover Env type');
    }

    public static function updateRouteCachePath(Application $app): void
    {
        if (!$old = static::findOldRouteCachePath($app)) {
            return;
        }

        static::setEnv(
            static::ROUTE_CACHE_PATH_ENV,
            static::buildNewRouteCachePath($old),
        );
    }
}
