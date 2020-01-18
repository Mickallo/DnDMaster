<?php

declare(strict_types=1);

namespace App\Character\Application\Query;

use App\Character\Domain\ReadModel\CharacterRepository;
use App\Character\Domain\ValueType\Uuid;
use App\Common\DDD\Query;
use App\Common\DDD\QueryHandler;
use App\Common\DDD\QueryResponse;

class ShowCharacterQueryHandler implements QueryHandler
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Query $query): QueryResponse
    {
        return QueryResponse::withValue(
            $this->repository->show(Uuid::fromString($query->uuid))
        );
    }

    public function listenTo(): string
    {
        return ShowCharacterQuery::class;
    }
}
