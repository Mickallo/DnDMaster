<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Event;

final class CharacterNameChanged implements Event
{
    public Uuid $characterUuid;
    public string $name;

    public function __construct(Uuid $characterUuid, string $name)
    {
        $this->characterUuid = $characterUuid;
        $this->name = $name;
    }
}
