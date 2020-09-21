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
    ): void {
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
        \Closure $callback
    ): void {
        //$callback(new AMQPMessage('basicConsume callback'));
        $callback(
            (object) [
                'body' => 'basicConsume callback',
                'delivery_info' => [
                    'channel' => new EmptyChannel(),
                    'delivery_tag' => null,
                ],
            ]
        );
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

    public function basic_ack(?int $deliveryTag, bool $multiple = false): void
    {
    }

    public function basicQos(?int $prefetchSize, int $prefetchCount, ?bool $aGlobal)
    {
    }
}
