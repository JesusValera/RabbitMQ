<?php

declare(strict_types=1);

namespace RabbitMQ\HelloWorld;

use RabbitMQ\Connection\ChannelInterface;
use RabbitMQ\IO\WriterInterface;

final class Receiver
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

    public function consume(): void
    {
        $this->channel->queueDeclare('hello', false, false, false, false);

        $this->writer->write(" [x] Waiting for messages. To exit press Ctrl+C\n");

        $callback = fn ($message) => $this->writer->write(" [x] Received {$message->body}\n");
        $this->channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($this->channel->isConsuming()) {
            $this->channel->wait();
        }
    }
}
