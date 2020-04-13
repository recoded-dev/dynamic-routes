<?php

namespace Recoded\DynamicRoutes\Console\Commands;

use Illuminate\Foundation\Console\RouteClearCommand as Command;
use Recoded\DynamicRoutes\Concerns\HasRouteKeyBasedCalls;
use Recoded\DynamicRoutes\Contracts\DynamicRouteResolver;

class RouteClearCommand extends Command
{
    use HasRouteKeyBasedCalls;

    public function handle(): void
    {
        /** @var \Recoded\DynamicRoutes\Contracts\DynamicRouteResolver $resolver */
        $resolver = app(DynamicRouteResolver::class);

        foreach ($resolver->possibilities() as $possibility) {
            $this->withRouteKey($possibility, fn () => parent::handle());
        }
    }
}
