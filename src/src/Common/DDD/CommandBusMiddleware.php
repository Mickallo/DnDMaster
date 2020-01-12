<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface CommandBusMiddleware
{
    public function dispatch(Command $command): CommandResponse;
}
