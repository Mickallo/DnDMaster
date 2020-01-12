<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface QueryBus
{
    public function dispatch(Query $query): QueryResponse;
}
