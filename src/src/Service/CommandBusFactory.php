<?php

declare(strict_types=1);

namespace App\Service;

use App\Common\DDD\CommandBus;
use App\Common\DDD\EventBus;
use App\Service\CommandBusMiddleware\Dispatcher;
use App\Service\CommandBusMiddleware\DoctrineFlush;
use App\Service\CommandBusMiddleware\EventDispatcher;
use App\Service\CommandBusMiddleware\Logger;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class CommandBusFactory
{
    public static function build(
        iterable $handler,
        LoggerInterface $logger,
        ManagerRegistry $registry,
        EventBus $eventBus
    ): CommandBus {
        $bus =
            new Logger(
                new DoctrineFlush(
                    new EventDispatcher(
                        new Dispatcher($handler),
                        $eventBus
                    ),
                    $registry
                ),
                $logger
            );

        return $bus;
    }
}
