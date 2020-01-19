<?php

declare(strict_types=1);

namespace App\Character\Ui\Controller;

use App\Character\Application\Command\ChangeCharacterNameCommand;
use App\Character\Application\Command\CreateCharacterCommand;
use App\Character\Application\Command\DeleteCharacterCommand;
use App\Character\Application\Query\ListCharactersQuery;
use App\Character\Application\Query\ShowCharacterQuery;
use App\Common\DDD\CommandBus;
use App\Common\DDD\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $response = $this->queryBus->dispatch(ListCharactersQuery::create());

        return $this->render('character/index.html.twig', [
            'characters' => $response->value(),
        ]);
    }

    /**
     * @Route("/create", name="character_create", methods={"GET"})
     */
    public function create(): Response
    {
        $command = new CreateCharacterCommand();

        $response = $this->commandBus->dispatch($command);

        return $this->render('character/index.html.twig', [
            'characters' => [$response->value()],
        ]);
    }

    /**
     * @Route("/{uuid}", name="character_show", methods={"GET"})
     */
    public function show(string $uuid): Response
    {
        $query = ShowCharacterQuery::create($uuid);

        $response = $this->queryBus->dispatch($query);

        return $this->render('character/show.html.twig', [
            'character' => $response->value(),
        ]);
    }

    /**
     * @Route("/{uuid}", name="character_delete", methods={"DELETE"})
     */
    public function delete(string $uuid): Response
    {
        $command = DeleteCharacterCommand::create($uuid);

        $this->commandBus->dispatch($command);

        return $this->redirectToRoute('character_index');
    }

    /**
     * @Route("/{uuid}/change-name", name="character_change_name", methods={"GET","POST"})
     */
    public function change_name(Request $request, string $uuid): Response
    {
        $character = ($this->queryBus->dispatch(ShowCharacterQuery::create($uuid)))->value();

        $command = new ChangeCharacterNameCommand($uuid, $character->name());

        $form = $this->createFormBuilder($command)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Change Name'])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData();
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('character_index');
        }

        return $this->render('character/edit.html.twig', [
            'form' => $form->createView(),
            'character' => $character,
        ]);
    }
}
