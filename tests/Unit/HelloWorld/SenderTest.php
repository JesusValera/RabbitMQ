<?php

declare(strict_types=1);

namespace RabbitMQTrainingTests\Unit\HelloWorld;

use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;
use RabbitMQTraining\Connection\EmptyChannel;
use RabbitMQTraining\HelloWorld\Sender;
use RabbitMQTrainingTests\Unit\InMemoryWriter;

class SenderTest extends TestCase
{
    /** @test */
    public function publish(): void
    {
        $writer = new InMemoryWriter();
        $sender = new Sender($writer, new EmptyChannel());
        $sender->publish(new AMQPMessage('Hello World!'));

        self::assertSame(
            [" [x] Sent 'Hello World!'\n"],
            $writer->messages()
        );
    }
}
