<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface QueryBusMiddleware
{
    public function dispatch(Query $command): QueryResponse;
}
