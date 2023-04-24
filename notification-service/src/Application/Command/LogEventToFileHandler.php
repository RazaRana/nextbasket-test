<?php

namespace App\Application\Command;

use App\Domain\User\Event\UserCreatedEvent;

class LogEventToFileHandler
{
    private string $logFilePath;

    public function __construct(string $logFilePath)
    {
        $this->logFilePath = $logFilePath;
    }

    public function __invoke(UserCreatedEvent $event): void
    {
        var_dump($this->logFilePath);
        $message = sprintf(
            "[%s] email: %s first name: %s last name: %s\n",
            $event->getUserId(),
            $event->getEmail(),
            $event->getFirstName(),
            $event->getLastName(),
        );
        file_put_contents($this->logFilePath, $message, FILE_APPEND);
    }
}
