<?php

declare(strict_types=1);

namespace App\Character\Ui\Controller;

use App\Character\Application\Command\CreateCharacterCommand;
use App\Character\Application\Query\ListCharactersQuery;
use App\Common\DDD\CommandBus;
use App\Common\DDD\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/character")
 */
class CharacterController extends AbstractController
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;
    private SerializerInterface $serializer;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, SerializerInterface $serializer)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="character_index", methods={"GET"})
     */
    public function index(): Response
    {
        $response = $this->queryBus->dispatch(new ListCharactersQuery());

        return $this->render('character/index.html.twig', [
            'characters' => $response->value(),
        ]);
    }

    /**
     * @Route("/create", name="character_create", methods={"GET"})
     */
    public function create(Request $request): Response
    {
        $command = new CreateCharacterCommand('Ezo');

        $response = $this->commandBus->dispatch($command);

        return $this->render('character/index.html.twig', [
            'characters' => [$response->value()],
        ]);
    }
}
