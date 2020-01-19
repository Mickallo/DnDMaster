<?php

declare(strict_types=1);

namespace App\Service\QueryBusMiddleware;

use App\Common\DDD\Query;
use App\Common\DDD\QueryBusMiddleware;
use App\Common\DDD\QueryResponse;
use Psr\Cache\CacheItemPoolInterface;

class Cacher implements QueryBusMiddleware
{
    private QueryBusMiddleware $next;
    private CacheItemPoolInterface $cache;

    public function __construct(QueryBusMiddleware $next, CacheItemPoolInterface $cache)
    {
        $this->next = $next;
        $this->cache = $cache;
    }

    public function dispatch(Query $query): QueryResponse
    {
        $key = md5($query->identifier());

        $item = $this->cache->getItem($key);

        if (!$item->isHit()) {
            $queryResponse = $this->next->dispatch($query);
            $item->set($queryResponse);
            $item->expiresAfter(10);
            $this->cache->save($item);
        } else {
            $queryResponse = $item->get();
        }

        return $queryResponse;
    }
}
