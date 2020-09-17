<?php

declare(strict_types=1);

namespace RabbitMQTests\Unit\HelloWorld;

use PHPUnit\Framework\TestCase;
use RabbitMQ\HelloWorld\Sender;
use RabbitMQTests\Unit\Writer;

class SenderTest extends TestCase
{
    /** @test */
    public function receiveConsume(): void
    {
        $writer = new Writer();
        $sender = new Sender($writer, new StreamConnectionFaker());
        $sender->publish();

        self::assertSame(
            [
                " [x] Sent 'Hello World!'\n",
            ],
            $writer->messages
        );
    }
}
