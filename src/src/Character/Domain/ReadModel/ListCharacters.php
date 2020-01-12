<?php

declare(strict_types=1);

namespace App\Character\Domain\ReadModel;

class ListCharacters
{
    private array $characters;

    public function __construct(array $characters)
    {
        $this->characters = $characters;
    }
}
