<?php

namespace App\Application\Command;

class LogEventToFileHandler
{
    public function __invoke(LogEventToFileCommand $command): void
    {
        $event = $command->getEvent();
        $logFilePath = $command->getLogFilePath();
        var_dump($logFilePath);
        $message = sprintf(
            "[%s] %s\n",
            $event->getOccurredAt()->format('Y-m-d H:i:s'),
            $event->getMessage()
        );
        file_put_contents($logFilePath, $message, FILE_APPEND);
    }
}
