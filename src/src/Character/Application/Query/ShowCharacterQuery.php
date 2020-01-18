<?php

declare(strict_types=1);

namespace App\Character\Application\Query;

use App\Common\DDD\Query;

class ShowCharacterQuery implements Query
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

    public function identifier(): string
    {
        return self::class.$this->uuid;
    }
}
