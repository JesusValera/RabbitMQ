<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

final class Channel implements ChannelInterface
{
    private AMQPChannel $channel;

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    public function queue_declare(
        string $queueName,
        bool $passive,
        bool $durable,
        bool $exclusive,
        bool $autoDelete
    ): void {
        $this->channel->queue_declare($queueName, $passive, $durable, $exclusive, $autoDelete);
    }

    public function close(): void
    {
        $this->channel->close();
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
        $this->channel->basic_consume($queueName, $consumerTag, $noLocal, $noAck, $exclusive, $noWait, $callback);
    }

    public function is_consuming(): bool
    {
        return $this->channel->is_consuming();
    }

    public function wait(): void
    {
        $this->channel->wait();
    }

    public function basic_publish(AMQPMessage $message, string $exchange, string $routingKey): void
    {
        $this->channel->basic_publish($message, $exchange, $routingKey);
    }
}
