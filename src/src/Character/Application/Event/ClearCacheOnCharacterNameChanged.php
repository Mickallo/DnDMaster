<?php

declare(strict_types=1);

namespace App\Character\Application\Event;

use App\Character\Application\Query\ListCharactersQuery;
use App\Character\Application\Query\ShowCharacterQuery;
use App\Character\Domain\CharacterNameChanged;
use App\Character\Domain\CharacterRepository;
use App\Common\DDD\Event;
use App\Common\DDD\EventHandler;
use Psr\Cache\CacheItemPoolInterface;

final class ClearCacheOnCharacterNameChanged implements EventHandler
{
    private CharacterRepository $repository;
    private CacheItemPoolInterface $cache;

    public function __construct(CharacterRepository $repository, CacheItemPoolInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function handle(Event $event): void
    {
        $items = [
            md5(ListCharactersQuery::class),
            md5(ShowCharacterQuery::class.$event->characterUuid),
        ];
        $this->cache->deleteItems($items);
    }

    public function listenTo(): string
    {
        return CharacterNameChanged::class;
    }
}
