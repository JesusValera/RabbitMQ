<?php

declare(strict_types=1);

namespace RabbitMQTraining\Topics;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class LogReceiverTopics
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

    public function consume(array $bindingKeys)
    {
        $this->channel->exchangeDeclare('topic_logs', 'topic', false, false, false);
        [$queueName] = $this->channel->queueDeclare('', false, false, true, false);

        foreach ($bindingKeys as $bindingKey) {
            $this->channel->queueBind($queueName, 'topic_logs', $bindingKey);
        }

        $this->writer->write(" [x] Waiting for logs. To exit press Ctrl+C\n");

        $callback = function (AMQPMessage $message) {
            $this->writer->write(" [x] {$message->getRoutingKey()}: {$message->getBody()}\n");
        };

        $this->channel->basicConsume($queueName, '', false, true, false, false, $callback);

        while ($this->channel->isConsuming()) {
            $this->channel->wait();
        }
    }
}
