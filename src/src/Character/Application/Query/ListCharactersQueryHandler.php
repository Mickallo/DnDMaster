<?php

declare(strict_types=1);

namespace App\Character\Application\Query;

use App\Character\Application\ViewModel\CharacterViewModel;
use App\Character\Domain\Character;
use App\Character\Domain\ReadModel\ListCharactersRepository;
use App\Common\DDD\Query;
use App\Common\DDD\QueryHandler;
use App\Common\DDD\QueryResponse;

class ListCharactersQueryHandler implements QueryHandler
{
    private ListCharactersRepository $repository;

    public function __construct(ListCharactersRepository $repository)
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
                $this->repository->listCharacters()
            )
        );
    }

    public function listenTo(): string
    {
        return ListCharactersQuery::class;
    }
}
