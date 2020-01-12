<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Common\DDD\Event;
use App\Common\DDD\Uuid;

final class CharacterCreated implements Event
{
    public Uuid $newCharacterId;

    public function __construct(Uuid $newCharacterId)
    {
        $this->newCharacterId = $newCharacterId;
    }
}
