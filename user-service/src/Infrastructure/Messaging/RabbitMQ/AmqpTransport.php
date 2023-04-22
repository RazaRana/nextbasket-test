<?php

namespace App\Infrastructure\Messaging\RabbitMQ;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\TransportException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class AmqpTransport implements TransportInterface
{
    private SerializerInterface $serializer;
    private AMQPStreamConnection $connection;
    private AbstractChannel|AMQPChannel $channel;
    private string $exchangeName;
    private string $queueName;

    public function __construct(
        SerializerInterface $serializer,
        AMQPStreamConnection $connection,
        string $exchangeName,
        string $queueName
    ) {
        $this->serializer = $serializer;
        $this->connection = $connection;
        $this->channel = $connection->channel();
        $this->exchangeName = $exchangeName;
        $this->queueName = $queueName;
    }

    public function receive(callable $handler): void
    {
        $this->channel->queue_declare($this->queueName, false, true, false, false);

        $this->channel->basic_consume(
            $this->queueName,
            '',
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) use ($handler) {
                try {
                    $envelope = $this->serializer->decode([
                        'body' => $message->getBody(),
                        'headers' => $message->get_properties(),
                    ]);
                    $handler($envelope, $this);
                } catch (\Throwable $exception) {
                    throw new TransportException($exception->getMessage(), 0, $exception);
                } finally {
                    $this->channel->basic_ack($message->getDeliveryTag());
                }
            }
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function send(Envelope $envelope): Envelope
    {
        $encodedEnvelope = $this->serializer->encode($envelope);
        $messageBody = $encodedEnvelope['body'];

        $message = new AMQPMessage(
            $messageBody,
            [
                'Content-Type' => 'application/json',
                'message_type' => get_class($envelope->getMessage()),
            ]
        );

        $this->channel->basic_publish($message, $this->exchangeName);

        return $envelope;
    }

    /**
     * @throws \Exception
     */
    public function stop(): void
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function get(): iterable
    {
        return [];
    }

    public function ack(Envelope $envelope): void
    {
        // TODO: Implement ack() method.
    }

    public function reject(Envelope $envelope): void
    {
        // TODO: Implement reject() method.
    }
}
