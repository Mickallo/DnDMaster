<?php

declare(strict_types=1);

namespace App\Common\DDD;

class CommandResponse
{
    private $value;
    private array $events;

    private function __construct($value, array $events = [])
    {
        $this->value = $value;
        $this->events = $events;
    }

    public static function withValue($value, Event ...$events): self
    {
        return new self($value, $events);
    }

    public function value()
    {
        return $this->value;
    }

    public function hasEvents(): bool
    {
        return count($this->events) > 0;
    }

    public function events(): array
    {
        return $this->events;
    }
}
