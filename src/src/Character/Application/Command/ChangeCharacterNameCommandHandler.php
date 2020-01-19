<?php

declare(strict_types=1);

namespace App\Character\Application\Command;

use App\Character\Domain\CharacterNameChanged;
use App\Character\Domain\CharacterRepository;
use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Command;
use App\Common\DDD\CommandHandler;
use App\Common\DDD\CommandResponse;

final class ChangeCharacterNameCommandHandler implements CommandHandler
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Command $command): CommandResponse
    {
        $uuid = Uuid::fromString($command->uuid);
        $character = $this->repository->get($uuid);
        $character->changeName($command->name);
        $this->repository->save($character);

        return CommandResponse::withValue(
            $character,
            new CharacterNameChanged($uuid, $command->name)
        );
    }

    public function listenTo(): string
    {
        return ChangeCharacterNameCommand::class;
    }
}
