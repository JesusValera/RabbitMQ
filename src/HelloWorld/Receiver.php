<?php

declare(strict_types=1);

namespace RabbitMQ\HelloWorld;

use RabbitMQ\Connection\StreamConnectionInterface;
use RabbitMQ\IO\WriterInterface;

final class Receiver
{
    private WriterInterface $writer;
    private StreamConnectionInterface $connection;

    public function __construct(WriterInterface $writer, StreamConnectionInterface $connection)
    {
        $this->writer = $writer;
        $this->connection = $connection;
    }

    public function __destruct()
    {
        $this->connection->channel()->close();
        $this->connection->close();
    }

    public function consume(): void
    {
        $channel = $this->connection->channel();

        $channel->queue_declare('hello', false, false, false, false);

        $this->writer->write(" [x] Waiting for messages. To exit press Ctrl+C\n");

        $callback = fn ($message) => $this->writer->write(" [x] Received {$message->body}\n");
        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
