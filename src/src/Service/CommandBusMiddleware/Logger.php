<?php

declare(strict_types=1);

namespace App\Service\CommandBusMiddleware;

use App\Common\DDD\Command;
use App\Common\DDD\CommandBusMiddleware;
use App\Common\DDD\CommandResponse;
use Psr\Log\LoggerInterface;

class Logger implements CommandBusMiddleware
{
    private CommandBusMiddleware $next;
    private LoggerInterface $logger;

    public function __construct(CommandBusMiddleware $next, LoggerInterface $logger)
    {
        $this->next = $next;
        $this->logger = $logger;
    }

    public function dispatch(Command $command): CommandResponse
    {
        $startTime = microtime(true);
        $commandResponse = $this->next->dispatch($command);
        $endTime = microtime(true);
        $elapsed = $endTime - $startTime;

        $message = 'Command '.get_class($command).' took: '.$elapsed;
        $this->logger->info($message);

        return $commandResponse;
    }
}
