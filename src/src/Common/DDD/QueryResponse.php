<?php

declare(strict_types=1);

namespace App\Common\DDD;

class QueryResponse
{
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function withValue($value): self
    {
        return new self($value);
    }

    public function value()
    {
        return $this->value;
    }
}
