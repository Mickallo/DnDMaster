<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\CommandBusMiddleware;

use App\Common\DDD\Command;
use App\Common\DDD\CommandBusMiddleware;
use App\Common\DDD\CommandResponse;

class Dispatcher implements CommandBusMiddleware
{
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            $this->handlers[$handler->listenTo()] = $handler;
        }
    }

    public function dispatch(Command $command): CommandResponse
    {
        $commandClass = get_class($command);
        $handler = $this->handlers[$commandClass];

        if (null == $handler) {
            throw new \LogicException("Handler for command $commandClass not found");
        }

        return $handler->handle($command);
    }
}
