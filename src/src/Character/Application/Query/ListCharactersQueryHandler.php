<?php

declare(strict_types=1);

namespace App\Character\Application\Query;

use App\Character\Application\ViewModel\CharacterViewModel;
use App\Character\Domain\ReadModel\Character;
use App\Character\Domain\ReadModel\CharacterRepository;
use App\Common\DDD\Query;
use App\Common\DDD\QueryHandler;
use App\Common\DDD\QueryResponse;

class ListCharactersQueryHandler implements QueryHandler
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Query $query): QueryResponse
    {
        return QueryResponse::withValue(
            array_map(
                function (Character $character) {
                    return CharacterViewModel::fromEntity($character);
                },
                $this->repository->list()
            )
        );
    }

    public function listenTo(): string
    {
        return ListCharactersQuery::class;
    }
}
