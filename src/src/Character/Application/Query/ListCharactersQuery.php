<?php

declare(strict_types=1);

namespace App\Character\Application\Query;

use App\Common\DDD\Query;

class ListCharactersQuery implements Query
{
    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function identifier(): string
    {
        return self::class;
    }
}
