<?php

namespace Recoded\DynamicRoutes\RouteResolvers;

use Illuminate\Contracts\Foundation\Application;
use Recoded\DynamicRoutes\Contracts\DynamicRouteResolver;

class LocaleRouteResolver implements DynamicRouteResolver
{
    protected string $langPath;

    public function __construct(Application $application)
    {
        $this->langPath = rtrim($application['path.lang'], '/');
    }

    /**
     * @inheritDoc
     */
    public function possibilities(): array
    {
        return array_map(
            'basename',
            array_filter(
                glob($this->langPath . '/*'),
                'is_dir',
            ),
        );
    }

    /**
     * @inheritDoc
     */
    public function resolve(): string
    {
        return app()->getLocale();
    }
}
