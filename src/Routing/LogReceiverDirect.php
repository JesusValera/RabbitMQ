<?php

declare(strict_types=1);

namespace RabbitMQTraining\Routing;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class LogReceiverDirect
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

    public function consume(array $severities)
    {
        $this->channel->exchangeDeclare('direct_logs', 'direct', false, false, false);
        [$queueName] = $this->channel->queueDeclare('', false, false, true, false);

        foreach ($severities as $severity) {
            $this->channel->queueBind($queueName, 'direct_logs', $severity);
        }

        $this->writer->write(" [*] Waiting for logs. To exit press CTRL+C\n");

        $callback = function (AMQPMessage $message) {
            $this->writer->write(" [x] {$message->getRoutingKey()}: {$message->getBody()}\n");
        };

        $this->channel->basicConsume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->isConsuming()) {
            $this->channel->wait();
        }
    }
}
