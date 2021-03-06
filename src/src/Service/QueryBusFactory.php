<?php

declare(strict_types=1);

namespace App\Service;

use App\Common\DDD\QueryBus;
use App\Service\QueryBusMiddleware\Cacher;
use App\Service\QueryBusMiddleware\Dispatcher;
use Psr\Cache\CacheItemPoolInterface;

class QueryBusFactory
{
    public static function build(
        iterable $handler,
        CacheItemPoolInterface $cache
    ): QueryBus {
        $bus =
            new Cacher(
                new Dispatcher(
                    $handler
                ),
                $cache
            );

        return $bus;
    }
}
