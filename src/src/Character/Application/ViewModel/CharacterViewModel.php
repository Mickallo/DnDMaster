<?php

declare(strict_types=1);

namespace App\Character\Application\ViewModel;

use App\Character\Domain\Character;
use App\Common\DDD\Uuid;

class CharacterViewModel
{
    public string $id;
    public string $name;

    private function __construct(Uuid $id, string $name)
    {
        $this->id = (string) $id;
        $this->name = $name;
    }

    public static function fromEntity(Character $character)
    {
        return new self($character->id(), $character->name());
    }
}
