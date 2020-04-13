<?php

namespace Recoded\DynamicRoutes\Concerns;

use Recoded\DynamicRoutes\RouteServiceProvider;

trait HasRouteKeyBasedCalls
{
    protected function withRouteKey(string $key, callable $cb)
    {
        $old = RouteServiceProvider::getRouteKey();
        RouteServiceProvider::setRouteKey($key);
        RouteServiceProvider::updateRouteCachePath($this->laravel);

        $value = value($cb);

        RouteServiceProvider::setRouteKey($old);
        RouteServiceProvider::updateRouteCachePath($this->laravel);

        return $value;
    }
}
