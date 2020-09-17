<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

use PhpAmqpLib\Connection\AMQPStreamConnection;

final class StreamConnection implements StreamConnectionInterface
{
    private AMQPStreamConnection $streamConnection;

    public function __construct(AMQPStreamConnection $streamConnection)
    {
        $this->streamConnection = $streamConnection;
    }

    public function channel(): ChannelInterface
    {
        return new Channel($this->streamConnection->channel());
    }

    public function close(): void
    {
        $this->streamConnection->close();
    }
}
