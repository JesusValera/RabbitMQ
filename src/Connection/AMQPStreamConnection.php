<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

use PhpAmqpLib\Connection\AMQPStreamConnection as RabbitAMQPStreamConnection;

final class AMQPStreamConnection implements StreamConnectionInterface
{
    private RabbitAMQPStreamConnection $streamConnection;

    public function __construct(string $host, string $port, string $username, string $password)
    {
        $this->streamConnection = new RabbitAMQPStreamConnection($host, $port, $username, $password);
    }

    public function channel(): ChannelInterface
    {
        return new AMQPChannel($this->streamConnection->channel());
    }

    public function close(): void
    {
        $this->streamConnection->close();
    }
}
