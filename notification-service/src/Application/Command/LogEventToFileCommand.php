<?php

namespace App\Application\Command;

use App\Domain\Event\RabbitMqEvent;

class LogEventToFileCommand
{
    private RabbitMqEvent $event;
    private string $logFilePath;

    public function __construct(RabbitMqEvent $event, string $logFilePath)
    {
        $this->event = $event;
        $this->logFilePath = $logFilePath;
    }

    public function getEvent(): RabbitMqEvent
    {
        return $this->event;
    }

    public function getLogFilePath(): string
    {
        return $this->logFilePath;
    }
}
