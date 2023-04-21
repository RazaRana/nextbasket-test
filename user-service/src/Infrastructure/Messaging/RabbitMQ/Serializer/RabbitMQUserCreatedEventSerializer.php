<?php

namespace App\Infrastructure\Messaging\RabbitMQ\Serializer;

use App\Domain\User\Event\UserCreatedEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class RabbitMQUserCreatedEventSerializer
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize(UserCreatedEvent $event): string
    {
        return $this->serializer->serialize($event, JsonEncoder::FORMAT);
    }

    public function deserialize(string $messageBody): UserCreatedEvent
    {
        return $this->serializer->deserialize(
            $messageBody,
            UserCreatedEvent::class,
            JsonEncoder::FORMAT,
            [AbstractNormalizer::OBJECT_TO_POPULATE => new UserCreatedEvent()]
        );
    }
}
