<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit\HelloWorld;

use PHPUnit\Framework\TestCase;
use RabbitMQ\Connection\EmptyChannel;
use RabbitMQ\HelloWorld\Receiver;
use RabbitMQTests\Unit\InMemoryWriter;

class ReceiverTest extends TestCase
{
    /** @test */
    public function consume(): void
    {
        $writer = new InMemoryWriter();
        $receiver = new Receiver($writer, new EmptyChannel());
        $receiver->consume();

        self::assertSame(
            [
                " [x] Waiting for messages. To exit press Ctrl+C\n",
                " [x] Received dummy channel\n",
            ],
            $writer->messages()
        );
    }
}
