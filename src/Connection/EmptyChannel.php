<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

use PhpAmqpLib\Message\AMQPMessage;

final class EmptyChannel implements ChannelInterface
{
    public function queueDeclare(
        string $queueName,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete
    ): void {
    }

    public function close(): void
    {
    }

    public function basic_consume(
        string $queueName,
        string $consumerTag,
        bool $noLocal,
        bool $noAck,
        bool $exclusive,
        bool $noWait,
        \Closure $callback
    ): void {
        $message = new \stdClass();
        $message->body = 'dummy channel';
        $callback($message);
    }

    public function isConsuming(): bool
    {
        return false;
    }

    public function wait(): void
    {
    }

    public function basicPublish(AMQPMessage $message, string $exchange, string $routingKey): void
    {
    }
}
