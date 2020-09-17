<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit\HelloWorld;

use PHPUnit\Framework\TestCase;
use RabbitMQ\HelloWorld\Receiver;
use RabbitMQTests\Unit\Writer;

class ReceiverTest extends TestCase
{
    /** @test */
    public function receiveConsume(): void
    {
        $writer = new Writer();
        $receiver = new Receiver($writer, new StreamConnectionFaker());
        $receiver->consume();

        self::assertSame(
            [
                " [x] Waiting for messages. To exit press Ctrl+C\n",
                " [x] Received dummy channel\n",
            ],
            $writer->messages
        );
    }
}
