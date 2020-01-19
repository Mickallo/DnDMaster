<?php

declare(strict_types=1);

namespace App\Service\CommandBusMiddleware;

use App\Common\DDD\Command;
use App\Common\DDD\CommandBusMiddleware;
use App\Common\DDD\CommandResponse;
use App\Common\DDD\EventBus;

class EventDispatcher implements CommandBusMiddleware
{
    private CommandBusMiddleware $bus;
    private EventBus $eventBus;

    public function __construct(CommandBusMiddleware $bus, EventBus $eventBus)
    {
        $this->bus = $bus;
        $this->eventBus = $eventBus;
    }

    public function dispatch(Command $command): CommandResponse
    {
        $commandResponse = $this->bus->dispatch($command);

        if ($commandResponse->hasEvents()) {
            foreach ($commandResponse->events() as $event) {
                $this->eventBus->dispatch($event);
            }
        }

        return $commandResponse;
    }
}
