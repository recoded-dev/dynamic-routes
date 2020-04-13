<?php

namespace Recoded\DynamicRoutes\Contracts;

interface DynamicRouteResolver
{
    /**
     * All possible variable values used to cache routes.
     *
     * @return array
     */
    public function possibilities(): array;

    /**
     * Resolve the current dynamic route variable.
     *
     * @return string
     */
    public function resolve(): string;
}
