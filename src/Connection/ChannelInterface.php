<?php

declare(strict_types=1);

namespace RabbitMQTraining\Connection;

use PhpAmqpLib\Message\AMQPMessage;

interface ChannelInterface
{
    public function queueDeclare(
        string $queueName,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete
    ): void;

    public function close(): void;

    public function basicConsume(
        string $queueName,
        string $consumerTag,
        bool $noLocal,
        bool $noAck,
        bool $exclusive,
        bool $noWait,
        \Closure $callback
    ): void;

    public function isConsuming(): bool;

    public function wait(): void;

    public function basicPublish(AMQPMessage $message, string $exchange, string $routingKey): void;

}
