<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Common\DDD\Uuid;

final class Character
{
    private Uuid $id;
    private string $name;

    private function __construct(
        Uuid $id,
        string $name = 'John'
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function create(): self
    {
        return new self(Uuid::create());
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function generateName(): void
    {
        $this->name = 'dritz';
    }
}
