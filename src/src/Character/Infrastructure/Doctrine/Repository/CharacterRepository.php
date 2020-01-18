<?php

declare(strict_types=1);

namespace App\Character\Infrastructure\Doctrine\Repository;

use App\Character\Domain\Character;
use App\Character\Domain\CharacterRepository as CharacterRepositoryInterface;
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

    public function get(Uuid $uuid): Character
    {
        /** @var Character $character */
        $character = $this->registry
            ->getManager()
            ->getRepository(Character::class)
            ->find($uuid);
        if (null === $character) {
            throw new EntityNotFoundException();
        }

        return $character;
    }

    public function save(Character $character): void
    {
        $this->registry->getManager()->persist($character);
    }

    public function add(Character $character): void
    {
        $this->save($character);
    }

    public function delete(Uuid $uuid): void
    {
        $character = $this->registry->getManager()->getPartialReference(Character::class, ['uuid' => $uuid]);
        $this->registry->getManager()->remove($character);
    }
}
