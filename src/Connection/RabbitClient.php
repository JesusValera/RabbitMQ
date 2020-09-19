<?php

declare(strict_types=1);

namespace RabbitMQ\Connection;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use RabbitMQ\ReadModel\RabbitClientCredentials;

final class RabbitClient
{
    public function getConnection(RabbitClientCredentials $credentials): StreamConnectionInterface
    {
        return new AMQPStreamConnection(
            new AMQPStreamConnection(
                $credentials->host,
                $credentials->port,
                $credentials->username,
                $credentials->password
            )
        );
    }
}
