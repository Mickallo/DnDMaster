<?php

declare(strict_types=1);

namespace App\Character\Domain\ReadModel;

use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Repository;

interface CharacterRepository extends Repository
{
    public function list(): array;

    public function show(Uuid $uuid): Character;
}
