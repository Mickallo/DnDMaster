<?php

declare(strict_types=1);

namespace App\Character\Domain\ReadModel;

use App\Character\Domain\ValueType\Uuid;

class Character
{
    private Uuid $uuid;
    private string $name;

    private function __construct(Uuid $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public static function create(Uuid $uuid, string $name): self
    {
        return new self($uuid, $name);
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }
}
