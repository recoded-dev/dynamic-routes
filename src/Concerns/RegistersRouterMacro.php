<?php

namespace Recoded\DynamicRoutes\Concerns;

use Illuminate\Routing\Router;

trait RegistersRouterMacro
{
    public function registerRouterMacro(): void
    {
        $key = $this->getRouteKey();

        Router::macro('dynamic', fn (callable $cb) => $cb($key));
    }
}
