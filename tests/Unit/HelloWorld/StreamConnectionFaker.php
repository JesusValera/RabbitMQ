<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit\HelloWorld;

use RabbitMQ\Connection\ChannelInterface;
use RabbitMQ\Connection\StreamConnectionInterface;

final class StreamConnectionFaker implements StreamConnectionInterface
{
    public function channel(): ChannelInterface
    {
        return new ChannelFaker();
    }

    public function close(): void
    {
    }
}
