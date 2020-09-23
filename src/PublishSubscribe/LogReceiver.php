<?php

declare(strict_types=1);

namespace RabbitMQTraining\PublishSubscribe;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class LogReceiver
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
        $this->channel->exchangeDeclare('logs', 'fanout', false, false, false);
        [$queueName] = $this->channel->queueDeclare('', false, false, true, false);
        $this->channel->queueBind($queueName, 'logs');
        $this->writer->write(" [x] Waiting for logs. To exit press Ctrl+C\n");

        $callback = function (AMQPMessage $message) {
            $this->writer->write(" [x] Received {$message->getBody()}\n");
        };
        $this->channel->basicConsume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->isConsuming()) {
            $this->channel->wait();
        }
    }
}
