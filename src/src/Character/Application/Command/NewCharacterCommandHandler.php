<?php

declare(strict_types=1);

namespace App\Character\Application\Command;

use App\Character\Domain\Character;
use App\Character\Domain\CharacterCreated;
use App\Character\Domain\CharacterRepository;
use App\Common\DDD\Command;
use App\Common\DDD\CommandHandler;
use App\Common\DDD\CommandResponse;

final class NewCharacterCommandHandler implements CommandHandler
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Command $command): CommandResponse
    {
        $character = Character::create($command->name);
        $this->repository->add($character);

        return CommandResponse::withValue(
            null,
            new CharacterCreated($character->uuid())
        );
    }

    public function listenTo(): string
    {
        return NewCharacterCommand::class;
    }
}
