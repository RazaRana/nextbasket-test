<?php

namespace App\Application\Command;

use App\Domain\User\Event\UserCreatedEvent;
use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Messaging\RabbitMQ\Producer\RabbitMQUserProducer;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class CreateUserCommandHandler implements MiddlewareInterface
{
    private UserRepositoryInterface $userRepository;
    private RabbitMQUserProducer $rabbitMQUserProducer;

    public function __construct(UserRepositoryInterface $userRepository,
                                RabbitMQUserProducer $rabbitMQUserProducer)
    {
        $this->userRepository = $userRepository;
        $this->rabbitMQUserProducer = $rabbitMQUserProducer;
    }

    /**
     * @throws UserAlreadyExistsException
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $command = $envelope->getMessage();

        if (!$command instanceof CreateUserCommand) {
            return $stack->next()->handle($envelope, $stack);
        }

        $user = User::create($command->getId(), $command->getEmail(), $command->getFirstName(), $command->getLastName());
        $user->ensureEmailIsUnique($this->userRepository);
        $user = $this->userRepository->createNew($user->getEmail(), $user->getFirstName(), $user->getLastName());

        $event = new UserCreatedEvent($user->getId(),$user->getEmail(),$user->getFirstName(),$user->getLastName());
        $this->rabbitMQUserProducer->publish($event);

        return $stack->next()->handle($envelope, $stack);
    }
}
