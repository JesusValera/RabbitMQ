<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit\HelloWorld;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Connection\ChannelInterface;

final class ChannelFaker implements ChannelInterface
{
    public function queue_declare(
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

    public function is_consuming(): bool
    {
        return false;
    }

    public function wait(): void
    {
    }

    public function basic_publish(AMQPMessage $message, string $exchange, string $routingKey): void
    {
    }
}
