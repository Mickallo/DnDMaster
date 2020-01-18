<?php

declare(strict_types=1);

namespace App\Character\Application\ViewModel;

use App\Character\Domain\ReadModel\Character;
use App\Character\Domain\ValueType\Uuid;

class CharacterViewModel
{
    public string $uuid;
    public string $name;

    private function __construct(Uuid $uuid, string $name)
    {
        $this->uuid = (string) $uuid;
        $this->name = $name;
    }

    public static function fromEntity(Character $character)
    {
        return new self($character->uuid(), $character->name());
    }
}
