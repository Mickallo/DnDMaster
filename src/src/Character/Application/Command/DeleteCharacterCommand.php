<?php

declare(strict_types=1);

namespace App\Character\Application\Command;

use App\Common\DDD\Command;

final class DeleteCharacterCommand implements Command
{
    public string $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function create(string $uuid): self
    {
        return new self($uuid);
    }
}
