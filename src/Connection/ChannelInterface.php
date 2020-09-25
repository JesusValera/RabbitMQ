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
    ): array;

    public function close(): void;

    public function basicConsume(
        string $queueName,
        string $consumerTag,
        bool $noLocal,
        bool $noAck,
        bool $exclusive,
        bool $noWait,
        /* callable */ $callback
    ): void;

    public function isConsuming(): bool;

    public function wait(): void;

    public function basicPublish(AMQPMessage $message, string $exchange, string $routingKey = ''): void;

    public function basicAck(?int $deliveryTag, bool $multiple = false): void;

    /**
     * @return mixed
     */
    public function basicQos(?int $prefetchSize, int $prefetchCount, ?bool $aGlobal);

    /**
     * @return null|mixed
     */
    public function exchangeDeclare(string $exchange, string $type, bool $passive, bool $durable, bool $autoDelete);

    /**
     * @return null|mixed
     */
    public function queueBind(string $queueName, string $exchange, string $routingKey = '');
}
