<?php

declare(strict_types=1);

namespace RabbitMQTraining\PublishSubscribe;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class LogEmitter
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
        $this->channel->exchangeDeclare('logs', 'fanout', false, false, false);
        $this->channel->basicPublish($message, 'logs');
        $this->writer->write(" [x] Sent {$message->getBody()}\n");
    }
}
