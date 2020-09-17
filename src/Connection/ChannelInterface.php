<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

use PhpAmqpLib\Message\AMQPMessage;

interface ChannelInterface
{
    public function queue_declare(
        string $queueName,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete
    ): void;

    public function close(): void;

    public function basic_consume(
        string $queueName,
        string $consumerTag,
        bool $noLocal,
        bool $noAck,
        bool $exclusive,
        bool $noWait,
        \Closure $callback
    ): void;

    public function is_consuming(): bool;

    public function wait(): void;

    public function basic_publish(AMQPMessage $message, string $exchange, string $routingKey): void;

}