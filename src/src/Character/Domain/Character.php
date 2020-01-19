<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Character\Domain\ValueType\Uuid;

final class Character
{
    private Uuid $uuid;
    private string $name;

    private function __construct(
        Uuid $uuid,
        string $name = 'John'
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public static function create(): self
    {
        return new self(Uuid::create());
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }
}
