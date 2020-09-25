<?php

declare(strict_types=1);

namespace RabbitMQTraining\Routing;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class LogEmitterDirect
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

    public function publish(string $severity, AMQPMessage $message): void
    {
        $this->channel->exchangeDeclare('direct_logs', 'direct', false, false, false);
        $this->channel->basicPublish($message, 'direct_logs', $severity);
        $this->writer->write(" [x] Sent {$severity}: {$message->getBody()}\n");
    }
}
