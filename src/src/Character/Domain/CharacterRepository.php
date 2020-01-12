<?php

declare(strict_types=1);

namespace App\Character\Domain;

use App\Common\DDD\Repository;
use App\Common\DDD\Uuid;

interface CharacterRepository extends Repository
{
    public function get(Uuid $uuid): Character;

    public function save(Character $character): void;

    public function add(Character $entity): void;

    public function delete(Uuid $uuid): void;
}
