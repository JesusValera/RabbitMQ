<?php

declare(strict_types=1);

namespace RabbitMQTraining\Rpc;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\Connection\UniqueIdInterface;
use RabbitMQTraining\IO\WriterInterface;

final class Client
{
    private WriterInterface $writer;
    private ChannelInterface $channel;
    private UniqueIdInterface $uniqueId;

    public function __construct(WriterInterface $writer, ChannelInterface $channel, UniqueIdInterface $uniqueId)
    {
        $this->writer = $writer;
        $this->channel = $channel;
        $this->uniqueId = $uniqueId;
    }

    public function __destruct()
    {
        $this->channel->close();
    }

    public function publish(int $number): void
    {
        [$callbackQueue] = $this->channel->queueDeclare('', false, false, true, false);
        $correlationId = $this->uniqueId->generate();
        $callback = $this->createCallback($correlationId, $response);
        $this->channel->basicConsume($callbackQueue, '', false, true, false, false, $callback);

        $message = new AMQPMessage(
            (string) $number,
            ['correlation_id' => $correlationId, 'reply_to' => $callbackQueue]
        );
        $this->channel->basicPublish($message, '', 'rpc_queue');
        while (!isset($response)) {
            $this->channel->wait();
        }

        $this->writer->write(" [.] Got {$response}\n");
    }

    private function createCallback(string $correlationId, &$response): callable
    {
        return function (AMQPMessage $message) use (&$response, $correlationId): void {
            if ($message->get('correlation_id') === $correlationId) {
                $response = $message->body;
            }
        };
    }
}
