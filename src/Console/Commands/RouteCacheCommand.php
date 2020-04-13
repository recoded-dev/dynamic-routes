<?php

namespace Recoded\DynamicRoutes\Console\Commands;

use Illuminate\Foundation\Console\RouteCacheCommand as Command;
use Recoded\DynamicRoutes\Concerns\HasRouteKeyBasedCalls;
use Recoded\DynamicRoutes\Contracts\DynamicRouteResolver;

class RouteCacheCommand extends Command
{
    use HasRouteKeyBasedCalls;

    public function handle(): void
    {
        /** @var \Recoded\DynamicRoutes\Contracts\DynamicRouteResolver $resolver */
        $resolver = app(DynamicRouteResolver::class);

        foreach ($resolver->possibilities() as $possibility) {
            $this->withRouteKey($possibility, function () {
                $this->files->delete($this->laravel->getCachedRoutesPath());

                parent::handle();
            });
        }
    }

    public function call($command, array $arguments = [])
    {
        if ($command === 'route:clear') {
            return;
        }

        return parent::call($command, $arguments);
    }
}
