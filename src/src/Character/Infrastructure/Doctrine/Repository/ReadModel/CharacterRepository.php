<?php

declare(strict_types=1);

namespace App\Character\Infrastructure\Doctrine\Repository\ReadModel;

use App\Character\Domain\ReadModel\Character;
use App\Character\Domain\ReadModel\CharacterRepository as CharacterRepositoryInterface;
use App\Character\Domain\ValueType\Uuid;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

final class CharacterRepository implements CharacterRepositoryInterface
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function list(): array
    {
        return $this->registry->getManager('readmodel')->getRepository(Character::class)->findAll();
    }

    public function show(Uuid $uuid): Character
    {
        /** @var Character $character */
        $character = $this->registry
            ->getManager('readmodel')
            ->getRepository(Character::class)
            ->find($uuid);
        if (null === $character) {
            throw new EntityNotFoundException();
        }

        return $character;
    }
}
