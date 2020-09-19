<?php

declare(strict_types=1);

namespace RabbitMQ\HelloWorld;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQ\Connection\ChannelInterface;
use RabbitMQ\IO\WriterInterface;

final class Sender
{
    private WriterInterface $writer;
    private ChannelInterface $channel;

    public function __construct(WriterInterface $writer, ChannelInterface $channel)
    {
        $this->writer = $writer;
        $this->channel = $channel;
    }

    public function __destruct()
    {
        $this->channel->close();
    }

    public function publish(): void
    {
        $this->channel->queueDeclare('hello', false, false, false, false);

        $message = new AMQPMessage('Hello World!');
        $this->channel->basicPublish($message, '', 'hello');

        $this->writer->write(" [x] Sent 'Hello World!'\n");
    }
}
