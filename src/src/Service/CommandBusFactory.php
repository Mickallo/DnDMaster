<?php

declare(strict_types=1);

namespace App\Service;

use App\Common\DDD\CommandBus;
use App\Common\DDD\EventBus;
use App\Common\Infrastructure\CommandBusMiddleware\Dispatcher;
use App\Common\Infrastructure\CommandBusMiddleware\DoctrineFlush;
use App\Common\Infrastructure\CommandBusMiddleware\EventDispatcher;
use App\Common\Infrastructure\CommandBusMiddleware\Logger;
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
