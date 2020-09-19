<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit\HelloWorld;

use PHPUnit\Framework\TestCase;
use RabbitMQ\Connection\EmptyChannel;
use RabbitMQ\HelloWorld\Sender;
use RabbitMQTests\Unit\InMemoryWriter;

class SenderTest extends TestCase
{
    /** @test */
    public function receiveConsume(): void
    {
        $writer = new InMemoryWriter();
        $sender = new Sender($writer, new EmptyChannel());
        $sender->publish();

        self::assertSame(
            [" [x] Sent 'Hello World!'\n"],
            $writer->messages()
        );
    }
}
