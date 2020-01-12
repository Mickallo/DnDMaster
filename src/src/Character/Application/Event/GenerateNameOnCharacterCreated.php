<?php

declare(strict_types=1);

namespace App\Character\Application\Event;

use App\Character\Domain\CharacterCreated;
use App\Character\Domain\CharacterRepository;
use App\Common\DDD\Event;
use App\Common\DDD\EventHandler;

final class GenerateNameOnCharacterCreated implements EventHandler
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Event $event): void
    {
        $character = $this->repository->get($event->newCharacterId);
        $character->generateName();
        $this->repository->save($character);
    }

    public function listenTo(): string
    {
        return CharacterCreated::class;
    }
}
