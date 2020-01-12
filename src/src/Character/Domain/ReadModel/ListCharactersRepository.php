<?php

declare(strict_types=1);

namespace App\Character\Domain\ReadModel;

use App\Common\DDD\Repository;

interface ListCharactersRepository extends Repository
{
    public function listCharacters(): array;
}
