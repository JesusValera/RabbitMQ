<?php

declare(strict_types=1);

namespace RabbitMQTraining\HelloWorld;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

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

    public function publish(AMQPMessage $message): void
    {
        $this->channel->queueDeclare('hello', false, false, false, false);
        $this->channel->basicPublish($message, '', 'hello');
        $this->writer->write(" [x] Sent '{$message->getBody()}'\n");
    }
}
