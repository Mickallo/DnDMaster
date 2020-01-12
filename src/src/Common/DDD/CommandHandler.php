<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface CommandHandler
{
    public function handle(Command $command): CommandResponse;

    public function listenTo(): string;
}
