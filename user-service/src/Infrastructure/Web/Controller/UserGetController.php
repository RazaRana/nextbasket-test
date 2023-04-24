<?php

namespace App\Infrastructure\Web\Controller;

use App\Application\Query\FindAllUsersQuery;
use App\Stamp\ResponseStamp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class UserGetController extends AbstractController
{

    private MessageBusInterface $messageBus;

    public function __construct(
        MessageBusInterface $commandBus,
    ) {
        $this->messageBus = $commandBus;
    }

    public function getAllUsers(): Response
    {
        $query = new FindAllUsersQuery();

        try {
            $response = $this->messageBus->dispatch($query)->last(ResponseStamp::class)->getResponse();

            return new JsonResponse(['users' => $response]);
        }catch (Throwable $e) {
            return new JsonResponse([
                'err' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
                'status' => 'error',
                'message' => 'An error occurred while processing the request'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
