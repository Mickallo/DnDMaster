<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Repository;

interface CharacterRepository extends Repository
{
    public function get(Uuid $uuid): Character;

    public function save(Character $character): void;

    public function add(Character $entity): void;

    public function delete(Uuid $uuid): void;
}
