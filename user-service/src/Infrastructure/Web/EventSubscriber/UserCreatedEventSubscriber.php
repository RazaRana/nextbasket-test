<?php

namespace App\Infrastructure\Web\EventSubscriber;

use App\Domain\User\Event\UserCreatedEvent;
use App\Infrastructure\Messaging\RabbitMQ\Producer\RabbitMQUserProducer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserCreatedEventSubscriber implements EventSubscriberInterface
{
    private RabbitMQUserProducer $rabbitMQUserProducer;

    public function __construct(RabbitMQUserProducer $rabbitMQUserProducer)
    {
        $this->rabbitMQUserProducer = $rabbitMQUserProducer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'onUserCreated',
        ];
    }

    public function onUserCreated(UserCreatedEvent $event): void
    {
        $user = $event->getUser();

        $serializedUser = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ];

        $this->rabbitMQUserProducer->publish($serializedUser);
    }
}
