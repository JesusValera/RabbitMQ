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
    ): array {
        return $this->channel->queue_declare($queueName, $passive, $durable, $exclusive, $autoDelete);
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
        /* callable */ $callback
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

    public function basicPublish(AMQPMessage $message, string $exchange, string $routingKey = ''): void
    {
        $this->channel->basic_publish($message, $exchange, $routingKey);
    }

    public function basicAck(?int $deliveryTag, bool $multiple = false): void
    {
        $this->channel->basic_ack($deliveryTag, $multiple);
    }

    public function basicQos(?int $prefetchSize, int $prefetchCount, ?bool $aGlobal)
    {
        $this->channel->basic_qos($prefetchSize, $prefetchCount, $aGlobal);
    }

    public function exchangeDeclare(string $exchange, string $type, bool $passive, bool $durable, bool $autoDelete)
    {
        $this->channel->exchange_declare($exchange, $type, $passive, $durable, $autoDelete);
    }

    public function queueBind(string $queueName, string $exchange)
    {
        return $this->channel->queue_bind($queueName, $exchange);
    }
}
