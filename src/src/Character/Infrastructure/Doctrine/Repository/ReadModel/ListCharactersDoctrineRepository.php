<?php

declare(strict_types=1);

namespace App\Character\Infrastructure\Doctrine\Repository\ReadModel;

use App\Character\Domain\Character;
use App\Character\Domain\ReadModel\ListCharactersRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ListCharactersDoctrineRepository implements ListCharactersRepository
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function listCharacters(): array
    {
        return $this->registry->getManager()->getRepository(Character::class)->findAll();
    }
}
