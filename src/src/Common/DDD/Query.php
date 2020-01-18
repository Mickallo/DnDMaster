<?php

declare(strict_types=1);

namespace App\Common\DDD;

interface Query
{
    public function identifier(): string;
}
