<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

final class EmptyStreamConnection implements StreamConnectionInterface
{
    public function channel(): ChannelInterface
    {
        return new EmptyChannel();
    }

    public function close(): void
    {
    }
}
