<?php

declare(strict_types=1);

namespace App\Character\Ui\Controller;

use App\Character\Application\Command\ChangeCharacterNameCommand;
use App\Character\Application\Command\DeleteCharacterCommand;
use App\Character\Application\Command\NewCharacterCommand;
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
 * @Route("/character", name="character_")
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
     * @Route("/", name="list", methods={"GET"})
     */
    public function index(): Response
    {
        $response = $this->queryBus->dispatch(ListCharactersQuery::create());

        return $this->render('character/list.html.twig', [
            'characters' => $response->value(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $name = 'Drizzt do\'urden';
        $command = new NewCharacterCommand($name);

        $form = $this->createFormBuilder($command)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData();
            $this->commandBus->dispatch($command);

            return $this->redirectToRoute('character_list');
        }

        return $this->render('character/new.html.twig', [
            'form' => $form->createView(),
            $command,
        ]);
    }

    /**
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(string $uuid): Response
    {
        $command = DeleteCharacterCommand::create($uuid);

        $this->commandBus->dispatch($command);

        return $this->redirectToRoute('character_list');
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
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
     * @Route("/{uuid}/change-name", name="change_name", methods={"GET","POST"})
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

            return $this->redirectToRoute('character_list');
        }

        return $this->render('character/change_name.html.twig', [
            'form' => $form->createView(),
            'character' => $character,
        ]);
    }
}
