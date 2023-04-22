<?php

namespace App\Infrastructure\Messaging\RabbitMQ\Producer;

use App\Domain\User\Event\UserCreatedEvent;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Messenger\Transport\Sender\SenderInterface;

class RabbitMQUserProducer
{
    private SenderInterface $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function publish(UserCreatedEvent $event, int $delay = null): void
    {
        $envelope = new Envelope($event);

        if ($delay) {
            $envelope = $envelope->with(new DelayStamp($delay));
        }

        $this->sender->send($envelope);
    }
}
