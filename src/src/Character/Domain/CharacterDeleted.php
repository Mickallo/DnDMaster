<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Event;

final class CharacterDeleted implements Event
{
    public Uuid $characterUuid;

    public function __construct(Uuid $characterUuid)
    {
        $this->characterUuid = $characterUuid;
    }
}
