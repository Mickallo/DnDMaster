<?php

declare(strict_types=1);

namespace App\Common\Infrastructure;

use App\Common\DDD\Event;
use App\Common\DDD\EventHandler;

class EventBus implements \App\Common\DDD\EventBus
{
    private array $handlers = [];

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            $this->handlers[] = $handler;
        }
    }

    public function dispatch(Event $event): void
    {
        $eventClass = get_class($event);
        $matchingHandlers = array_filter(
            $this->handlers,
            function (EventHandler $handler) use ($eventClass) {
                return $handler->listenTo() === $eventClass;
            }
        );

        foreach ($matchingHandlers as $handler) {
            $handler->handle($event);
        }
    }
}
