<?php

namespace App\Infrastructure\Messaging\RabbitMQ\Producer;

use App\Domain\User\Event\UserCreatedEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RabbitMQUserProducer
{
    private MessageBusInterface $messageBus;
    private SerializerInterface $serializer;

    public function __construct(MessageBusInterface $messageBus, SerializerInterface $serializer)
    {
        $this->messageBus = $messageBus;
        $this->serializer = $serializer;
    }

    public function produce(UserCreatedEvent $event): void
    {
        $serializedData = $this->serializer->serialize($event, 'json');

        // TODO: Connect to RabbitMQ and publish message with serializedData
        // Example code using PHP AMQP library:
        // $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        // $channel = $connection->channel();
        // $channel->queue_declare('user_created', false, false, false, false);
        // $message = new \PhpAmqpLib\Message\AMQPMessage($serializedData);
        // $channel->basic_publish($message, '', 'user_created');
        // $channel->close();
        // $connection->close();

        // Dispatch the event to Symfony Messenger after publishing to RabbitMQ
        $this->messageBus->dispatch($event);
    }
}
