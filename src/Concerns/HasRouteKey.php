<?php

namespace Recoded\DynamicRoutes\Concerns;

trait HasRouteKey
{
    protected static string $routeKey;

    public static function getRouteKey(): string
    {
        return static::$routeKey ??= static::resolve();
    }

    public static function refresh(): string
    {
        return static::setRouteKey(static::resolve());
    }

    public static function setRouteKey(string $routeKey): string
    {
        return static::$routeKey = $routeKey;
    }
}
