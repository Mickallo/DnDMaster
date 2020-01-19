<?php

declare(strict_types=1);

namespace App\Character\Application\Command;

use App\Character\Domain\CharacterDeleted;
use App\Character\Domain\CharacterRepository;
use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Command;
use App\Common\DDD\CommandHandler;
use App\Common\DDD\CommandResponse;

final class DeleteCharacterCommandHandler implements CommandHandler
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Command $command): CommandResponse
    {
        $uuid = Uuid::fromString($command->uuid);
        $this->repository->delete($uuid);

        return CommandResponse::withValue(
            null,
            new CharacterDeleted($uuid)
        );
    }

    public function listenTo(): string
    {
        return DeleteCharacterCommand::class;
    }
}
