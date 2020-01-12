<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface QueryHandler
{
    public function handle(Query $query);

    public function listenTo(): string;
}
