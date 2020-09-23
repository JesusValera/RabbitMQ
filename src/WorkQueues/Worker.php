<?php

declare(strict_types=1);

namespace RabbitMQTraining\WorkQueues;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\AmqpChannel;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class Worker
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
        $this->channel->queueDeclare('task_queue', false, $durable = true, false, false);
        $this->writer->write(" [x] Waiting for messages. To exit press Ctrl+C\n");

        $this->channel->basicQos(null, 1, null);
        $this->channel->basicConsume('task_queue', '', false, $noAck = false, false, false, $this->createCallback());

        while ($this->channel->isConsuming()) {
            $this->channel->wait();
        }
    }

    private function createCallback(): callable
    {
        return function (AMQPMessage $message) {
            $this->writer->write(" [x] Received {$message->getBody()}\n");
            sleep(substr_count($message->getBody(), '.'));
            $this->writer->write(" [x] Done\n");

            $this->channel = new AmqpChannel($message->getChannel());
            $this->channel->basicAck($message->getDeliveryTag());
        };
    }
}
