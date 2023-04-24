<?php

namespace App\Tests\Web\Controller;

use App\Application\Command\CreateUserCommand;
use App\Infrastructure\Web\Controller\UserCreateController;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;


class UserControllerTest extends TestCase
{
    private MessageBusInterface $commandBus;
    private UserCreateController $userController;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->commandBus = $this->createMock(MessageBusInterface::class);
        $this->userController = new UserCreateController($this->commandBus);
    }

    public function testCreateUserWithValidData(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];
        $command = new CreateUserCommand(
            $requestData['email'],
            $requestData['firstName'],
            $requestData['lastName']
        );

        $this->commandBus->expects(self::any())
            ->method('dispatch')
            ->willReturn(new Envelope($command));

        $request = new Request([], [], [], [], [], [], json_encode($requestData));
        $response = $this->userController->createUser($request);

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame('success', json_decode($response->getContent(), true)['status']);
        self::assertSame('User created successfully', json_decode($response->getContent(), true)['message']);
    }

    public function testCreateUserWithMissingData(): void
    {
        $requestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];

        $request = new Request([], [], [], [], [], [], json_encode($requestData));
        $response = $this->userController->createUser($request);

        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testCreateUserWithError(): void
    {
        $requestData = [
            'email' => 'test@example.com',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ];
        $command = new CreateUserCommand(
            $requestData['email'],
            $requestData['firstName'],
            $requestData['lastName']
        );

        $this->commandBus->expects(self::any())
            ->method('dispatch')
            ->with(self::equalTo($command))
            ->willThrowException(new HandlerFailedException(new Envelope($command), [new \Exception()]));

        $request = new Request([], [], [], [], [], [], json_encode($requestData));
        $response = $this->userController->createUser($request);

        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        self::assertSame('error', json_decode($response->getContent(), true)['status']);
        self::assertSame('An error occurred while processing the request', json_decode($response->getContent(), true)['message']);
    }

}