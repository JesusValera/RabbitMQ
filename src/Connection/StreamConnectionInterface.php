<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

interface StreamConnectionInterface
{
    public function channel(): ChannelInterface;

    public function close(): void;
}