<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Event;

final class CharacterCreated implements Event
{
    public Uuid $newCharacterId;

    public function __construct(Uuid $newCharacterId)
    {
        $this->newCharacterId = $newCharacterId;
    }
}
