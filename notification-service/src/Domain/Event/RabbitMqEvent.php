<?php

namespace App\Domain\Event;

use DateTimeImmutable;

class RabbitMqEvent
{
    private string $message;
    private DateTimeImmutable $occurredAt;

    public function __construct(string $message, DateTimeImmutable $occurredAt)
    {
        $this->message = $message;
        $this->occurredAt = $occurredAt;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
