<?php

declare(strict_types=1);

namespace App\Service\QueryBusMiddleware;

use App\Common\DDD\Query;
use App\Common\DDD\QueryBusMiddleware;
use App\Common\DDD\QueryResponse;

class Dispatcher implements QueryBusMiddleware
{
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        foreach ($handlers as $handler) {
            $this->handlers[$handler->listenTo()] = $handler;
        }
    }

    public function dispatch(Query $query): QueryResponse
    {
        $queryClass = get_class($query);
        $handler = $this->handlers[$queryClass];

        if (null == $handler) {
            throw new \LogicException("Handler for query $queryClass not found");
        }

        return $handler->handle($query);
    }
}
