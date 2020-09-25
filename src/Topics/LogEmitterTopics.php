<?php

declare(strict_types=1);

namespace RabbitMQTraining\Topics;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class LogEmitterTopics
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

    public function publish(string $routingKey, AMQPMessage $message): void
    {
        $this->channel->exchangeDeclare('topic_logs', 'topic', false, false, false);
        $this->channel->basicPublish($message, 'topic_logs', $routingKey);
        $this->writer->write(" [x] Sent {$routingKey}: {$message->getBody()}\n");
    }
}
