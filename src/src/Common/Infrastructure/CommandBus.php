<?php

declare(strict_types=1);

namespace App\Common\Infrastructure;

use App\Common\DDD\Command;
use App\Common\DDD\CommandBusMiddleware;
use App\Common\DDD\CommandResponse;

class CommandBus implements \App\Common\DDD\CommandBus
{
    private CommandBusMiddleware $next;

    public function __construct(CommandBusMiddleware $next)
    {
        $this->next = $next;
    }

    public function dispatch(Command $command): CommandResponse
    {
        return $this->next->dispatch($command);
    }
}
