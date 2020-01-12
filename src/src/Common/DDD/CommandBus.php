<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface CommandBus
{
    public function dispatch(Command $command): CommandResponse;
}
