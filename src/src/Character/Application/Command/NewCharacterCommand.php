<?php

declare(strict_types=1);

namespace App\Character\Application\Command;

use App\Common\DDD\Command;

final class NewCharacterCommand implements Command
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
