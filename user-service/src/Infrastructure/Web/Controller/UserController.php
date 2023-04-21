<?php

namespace App\Infrastructure\Web\Controller;

use App\Application\Query\FindAllUsersQuery;
use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Application\Command\CreateUserCommand;
use App\Domain\User\Service\UserCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class UserController extends AbstractController
{

    private MessageBusInterface $messageBus;

    public function __construct(
        MessageBusInterface $commandBus,
    ) {
        $this->messageBus = $commandBus;
    }

    public function createUser(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $email = $requestData['email'] ?? null;
        $firstName = $requestData['firstName'] ?? null;
        $lastName = $requestData['lastName'] ?? null;

        if (!$email || !$firstName || !$lastName) {
            return new JsonResponse(['error' => 'Missing required parameters'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $command = new CreateUserCommand($email, $firstName, $lastName);
            $this->messageBus->dispatch($command);

            return new JsonResponse([
                'status' => 'success',
                'message' => 'User created successfully'
            ]);
        }catch (Throwable $e) {
            return new JsonResponse([
                'err' => $e->getMessage(),
                'status' => 'error',
                'message' => 'An error occurred while processing the request'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAllUsers(): Response
    {
        $users = $this->userRepository->findAll();

        $userArray = array_map(function (User $user) {
            return $user->toArray();
        }, $users);

        return new JsonResponse($userArray);
    }
}
