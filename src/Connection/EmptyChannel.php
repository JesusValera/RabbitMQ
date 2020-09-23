<?php

declare(strict_types=1);

namespace RabbitMQTraining\Connection;

use PhpAmqpLib\Message\AMQPMessage;

final class EmptyChannel implements ChannelInterface
{
    public function queueDeclare(
        string $queueName,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete
    ): array {
        return [''];
    }

    public function close(): void
    {
    }

    public function basicConsume(
        string $queueName,
        string $consumerTag,
        bool $noLocal,
        bool $noAck,
        bool $exclusive,
        bool $noWait,
        /* callable */ $callback
    ): void {
        $channel = new class extends \PhpAmqpLib\Channel\AMQPChannel {
            public function __construct()
            {
            }

            public function basic_ack($deliveryTag, $multiple = false): void
            {
            }
        };
        $message = new AMQPMessage('basicConsume callback');
        $message->setChannel($channel);
        $message->setDeliveryTag(1);
        $callback($message);
    }

    public function isConsuming(): bool
    {
        return false;
    }

    public function wait(): void
    {
    }

    public function basicPublish(AMQPMessage $message, string $exchange, string $routingKey = ''): void
    {
    }

    public function basicAck(?int $deliveryTag, bool $multiple = false): void
    {
    }

    public function basicQos(?int $prefetchSize, int $prefetchCount, ?bool $aGlobal)
    {
    }

    public function exchangeDeclare(string $exchange, string $type, bool $passive, bool $durable, bool $autoDelete)
    {
    }

    public function queueBind(string $queueName, string $exchange)
    {
    }
}
