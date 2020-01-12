<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\CommandBusMiddleware;

use App\Common\DDD\Command;
use App\Common\DDD\CommandBusMiddleware;
use App\Common\DDD\CommandResponse;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineFlush implements CommandBusMiddleware
{
    private CommandBusMiddleware $next;
    private ManagerRegistry $registry;

    public function __construct(CommandBusMiddleware $next, ManagerRegistry $registry)
    {
        $this->next = $next;
        $this->registry = $registry;
    }

    public function dispatch(Command $command): CommandResponse
    {
        $this->registry->getConnection()->beginTransaction();
        try {
            $commandResponse = $this->next->dispatch($command);
            $this->registry->getManager()->flush();
            $this->registry->getConnection()->commit();
        } catch (\Exception $exception) {
            $this->registry->getConnection()->rollBack();
            throw $exception;
        }

        return $commandResponse;
    }
}
