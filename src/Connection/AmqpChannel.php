<?php

declare(strict_types=1);

namespace RabbitMQTraining\Connection;

use PhpAmqpLib\Channel\AMQPChannel as RabbitAmqpChannel;
use PhpAmqpLib\Message\AMQPMessage;

final class AmqpChannel implements ChannelInterface
{
    private RabbitAmqpChannel $channel;

    public function __construct(RabbitAmqpChannel $channel)
    {
        $this->channel = $channel;
    }

    public function queueDeclare(
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

    public function basicConsume(
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

    public function isConsuming(): bool
    {
        return $this->channel->is_consuming();
    }

    public function wait(): void
    {
        $this->channel->wait();
    }

    public function basicPublish(AMQPMessage $message, string $exchange, string $routingKey): void
    {
        $this->channel->basic_publish($message, $exchange, $routingKey);
    }
}
