<?php

namespace App\Application\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Worker;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:user-created-event-consumer',
    description: 'Consume UserCreatedEvent messages from the RabbitMQ queue'
)]
class UserCreatedEventConsumerCommand extends Command
{
    private Worker $worker;
    private string $rabbitMqConnectionString;
    private string $queueName;

    public function __construct(Worker $worker,  string $rabbitMqConnectionString, string $queueName)
    {
        parent::__construct();
        $this->worker = $worker;
        $this->rabbitMqConnectionString = $rabbitMqConnectionString;
        $this->queueName = $queueName;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->worker->run([
            'App\Domain\User\Event\UserCreatedEvent' => ['amqp://guest:guest@rabbitmq:5672/', 'created-users'],
        ]);

        return Command::SUCCESS;
    }
}

