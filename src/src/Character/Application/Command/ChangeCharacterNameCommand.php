<?php

declare(strict_types=1);

namespace App\Character\Application\Command;

use App\Common\DDD\Command;

final class ChangeCharacterNameCommand implements Command
{
    public string $uuid;
    public string $name;

    public function __construct(string $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }
}
