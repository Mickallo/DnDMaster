<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface EventHandler
{
    public function handle(Event $event): void;

    public function listenTo(): string;
}
