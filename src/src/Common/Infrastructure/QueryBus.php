<?php

declare(strict_types=1);

namespace App\Common\Infrastructure;

use App\Common\DDD\Query;
use App\Common\DDD\QueryBusMiddleware;
use App\Common\DDD\QueryResponse;

class QueryBus implements \App\Common\DDD\QueryBus
{
    private QueryBusMiddleware $next;

    public function __construct(QueryBusMiddleware $next)
    {
        $this->next = $next;
    }

    public function dispatch(Query $query): QueryResponse
    {
        return $this->next->dispatch($query);
    }
}
