<?php

declare(strict_types=1);

namespace RabbitMQTraining\Rpc;

use PhpAmqpLib\Message\AMQPMessage;
use RabbitMQTraining\Connection\ChannelInterface;
use RabbitMQTraining\IO\WriterInterface;

final class Server
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
        $this->channel->queueDeclare('rpc_queue', false, false, false, false);
        $this->writer->write(" [x] Awaiting RPC requests\n");
        $callback = function (AMQPMessage $request) {
            $number = intval($request->body);
            $this->writer->write(" [.] fib($number)\n");

            $message = new AMQPMessage(
                (string) $this->fibonacci($number),
                ['correlation_id' => $request->get('correlation_id')]
            );

            $request->getChannel()->basic_publish($message, '', $request->get('reply_to'));
            $request->getChannel()->basic_ack($request->getDeliveryTag());
        };

        $this->channel->basicQos(null, 1, null);
        $this->channel->basicConsume('rpc_queue', '', false, false, false, false, $callback);

        while ($this->channel->isConsuming()) {
            $this->channel->wait();
        }
    }

    private function fibonacci(int $number): int
    {
        if ($number <= 0) {
            return 0;
        }
        if ($number === 1) {
            return 1;
        }

        return $this->fibonacci($number - 1) + $this->fibonacci($number - 2);
    }
}
