<?php

declare(strict_types=1);

namespace App\Service;

use App\Common\DDD\EventBus;
use App\Service\EventBusMiddleware\Dispatcher;

class EventBusFactory
{
    public static function build(
        iterable $handler
    ): EventBus {
        $bus =
            new Dispatcher(
                $handler
            );

        return $bus;
    }
}
