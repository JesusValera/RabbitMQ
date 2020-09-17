<?php

declare(strict_types=1);

namespace RabbitMQ\HelloWorld;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Connection\StreamConnectionInterface;
use RabbitMQ\IO\WriterInterface;

final class Sender
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

    public function publish(): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare('hello', false, false, false, false);

        $message = new AMQPMessage('Hello World!');
        $channel->basic_publish($message, '', 'hello');

        $this->writer->write(" [x] Sent 'Hello World!'\n");
    }
}
